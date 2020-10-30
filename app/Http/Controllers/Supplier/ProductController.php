<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
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
        $products = Product::with('category', 'productDetails')->get();

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

    public function prepareProductDetailInfo($product, $data)
    {
        $productDetails = [];
        for ($i = 0; $i < $data['numOfRow']; $i++) {
            $listAttr = [];
            for ($j = 0; $j < count($data['attr']); $j++) {
                $attrName = $data['attr'][$j];
                $attrValue = $data[$attrName][$i];

                $listAttr = array_add($listAttr, $attrName, $attrValue);
            }

            $productDetail = [
                'list_attributes' => json_encode($listAttr),
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
}
