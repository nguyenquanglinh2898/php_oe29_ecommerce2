<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\EditProductFormRequest;
use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->with('category', 'productDetails')->get();

        return view('supplier.product.index', compact('products'));
    }

    public function create()
    {
        $rootCategories = Category::where('parent_id', null)->get();

        return view('supplier.product.create', compact('rootCategories'));
    }

    public function getChildCategories($rootCategoryId)
    {
        return Category::where('parent_id', $rootCategoryId)->get();
    }

    public function store(ProductFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->prepareProductInfo($request->all());
            $this->prepareProductDetailInfo($product, $request->all());
            $this->prepareImagesInfo($product, $request->all());

            DB::commit();
            Alert::success(trans('sentences.created_success'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('sentences.created_fail'));
        }

        return redirect()->route('supplier.products.index');
    }

    public function prepareProductInfo($data)
    {
        $thumbnail = $this->thumbnailName($data['thumbnail']);
        $remaining = array_sum($data['remaining']);
        $priceRange = $this->priceRange($data['price']);

        return Product::create([
            'name' => $data['name'],
            'weight' => $data['weight'],
            'brand' => $data['brand'],
            'description' => $data['description'],
            'thumbnail' => $thumbnail,
            'detail_info' => $data['detail_info'],
            'rate' => 0.0,
            'remaining' => $remaining,
            'price_range' => $priceRange,
            'status' => config('setting.pending_id'),
            'category_id' => $data['category_id'],
            'user_id' => Auth::user()->id,
        ]);
    }

    public function prepareProductDetailInfo($product, $data, $rowBegin = 0)
    {
        $productDetails = [];
        for ($i = $rowBegin; $i < $data['numOfRow']; $i++) {
            $listAttr = null;
            if (isset($data['attr'])) {
                $listAttr = [];
                for ($j = 0; $j < count($data['attr']); $j++) {
                    $attrName = $data['attr'][$j];
                    $attrValue = $data[$attrName][$i];

                    $listAttr = array_add($listAttr, $attrName, $attrValue);
                }
            }

            $productDetail = [
                'list_attributes' => json_encode($listAttr, JSON_UNESCAPED_UNICODE),
                'remaining' => $data['remaining'][$i],
                'price' => $data['price'][$i],
            ];

            array_push($productDetails, $productDetail);
        }

        $product->productDetails()->createMany($productDetails);
    }

    public function prepareImagesInfo($product, $data)
    {
        if (!isset($data['images'])) {
            return null;
        }

        $images = [];
        foreach ($data['images'] as $image) {
            $image->store('images', 'public');

            $imageItem = [
                'url' => $image->hashName(),
            ];

            array_push($images, $imageItem);
        }

        $product->images()->createMany($images);
    }

    public function thumbnailName($thumbnail)
    {
        $thumbnail->store('images', 'public');

        return $thumbnail->hashName();
    }

    public function priceRange($prices)
    {
        $minPrice = number_format(min($prices));
        $maxPrice = number_format(max($prices));

        return ($minPrice == $maxPrice) ? $minPrice : $minPrice.' - '.$maxPrice;
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->load('user', 'category', 'images', 'productDetails');

        return view('supplier.product.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();
        try {
            $product->productDetails()->delete();
            $product->images()->delete();
            $product->delete();

            DB::commit();
            Alert::success(trans('sentences.delete_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('sentences.delete_fail'));
        }

        return redirect()->route('supplier.products.index');
    }

    public function getAttributes($productDetails)
    {
        $attributes = json_decode($productDetails[0]->list_attributes, true);

        return array_keys($attributes);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $product->load('user', 'category', 'images', 'productDetails');

        $attributeNames = $this->getAttributes($product->productDetails);

        $parentCategoryId = Category::where('id', $product->category_id)->first()->parent_id;
        $rootCategories = Category::where('parent_id', null)->get();
        $childCategories = Category::where('parent_id', $parentCategoryId)->get();

        return view('supplier.product.edit', compact('product', 'attributeNames', 'parentCategoryId', 'rootCategories', 'childCategories'));
    }

    public function getThumbnail($currentProductThumbnail, $clientUploads)
    {
        if (isset($clientUploads['thumbnail'])) {
            $clientUploads['thumbnail']->store('images', 'public');

            return $clientUploads['thumbnail']->hashName();
        }

        return $currentProductThumbnail;
    }

    public function prepareUpdateProduct($product, $data)
    {
        $product->update([
            'name' => $data['name'],
            'weight' => $data['weight'],
            'brand' => $data['brand'],
            'description' => $data['description'],
            'thumbnail' => $this->getThumbnail($product->thumbnail, $data),
            'detail_info' => $data['detail_info'],
            'remaining' => array_sum($data['remaining']),
            'price_range' => $this->priceRange($data['price']),
            'category_id' => $data['category_id'],
        ]);
    }

    public function updateOldProductDetails($ids, $remaining, $price)
    {
        $cases = [];
        foreach ($ids as $id) {
            $cases[] = "WHEN {$id} then ?";
        }
        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        $params = array_merge($remaining, $price);

        $updateQuery = "UPDATE product_details
                        SET `remaining` = (CASE `id` {$cases} END), `price` = (CASE `id` {$cases} END)
                        WHERE `id` in ({$ids})";

        DB::update($updateQuery, $params);
    }

    public function prepareUpdateProductDetails($product, $data)
    {
        $existRemaining = array_slice($data['remaining'], 0, $data['currentNumberOfProductDetails']);
        $existPrice = array_slice($data['price'], 0, $data['currentNumberOfProductDetails']);

        $this->updateOldProductDetails($data['product_details_ids'], $existRemaining, $existPrice);
        $this->prepareProductDetailInfo($product, $data, $data['currentNumberOfProductDetails']);
    }

    public function updateOldImages($data)
    {
        if (!isset($data['old_image'])) {
            return null;
        }
        Image::whereIn('id', $data['old_image'])->forceDelete();
    }

    public function prepareUpdateImages($product, $data)
    {
        $this->updateOldImages($data);
        $this->prepareImagesInfo($product, $data);
    }

    public function update(EditProductFormRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            $this->prepareUpdateProduct($product, $request->all());
            $this->prepareUpdateProductDetails($product, $request->all());
            $this->prepareUpdateImages($product, $request->all());

            DB::commit();
            Alert::success(trans('sentences.update_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('sentences.update_fail'));
        }

        return redirect()->route('supplier.products.index');
    }
}
