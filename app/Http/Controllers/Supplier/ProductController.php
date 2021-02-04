<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\EditProductFormRequest;
use App\Http\Requests\ProductFormRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $imageRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo,
        ImageRepositoryInterface $imageRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->imageRepo = $imageRepo;
    }

    public function index()
    {
        $products = $this->productRepo->getSupplierProducts(Auth::id());

        return view('supplier.product.index', compact('products'));
    }

    public function create()
    {
        $rootCategories = $this->categoryRepo->getRootCategories();

        return view('supplier.product.create', compact('rootCategories'));
    }

    public function getChildCategories($rootCategoryId)
    {
        return $this->categoryRepo->getChildCategories($rootCategoryId);
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

        $attributes = [
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
        ];

        return $this->productRepo->create($attributes);
    }

    public function prepareProductDetailInfo($product, $data, $rowBegin = 0)
    {
        $productDetails = [];
        for ($i = $rowBegin; $i < $data['numOfRow']; $i++) {
            $listAttr = [];
            if (isset($data['attr'])) {
                for ($j = 0; $j < count($data['attr']); $j++) {
                    $attrName = $data['attr'][$j];
                    $attrValue = $data[$attrName][$i];

                    $listAttr = array_add($listAttr, $attrName, $attrValue);
                }
            }

            $productDetail = [
                'list_attributes' => json_encode($listAttr),
                'remaining' => $data['remaining'][$i],
                'price' => $data['price'][$i],
            ];

            array_push($productDetails, $productDetail);
        }

        $this->productRepo->createManyProductDetail($product, $productDetails);
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

        $this->productRepo->createManyImage($product, $images);
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
        $product = $this->productRepo->showProduct($id);

        return view('supplier.product.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = $this->productRepo->find($id);

        DB::beginTransaction();
        try {
            $this->productRepo->deleteProductDetails($product);
            $this->productRepo->deleteProductImages($product);
            $this->productRepo->deleteProductComments($product);
            $this->productRepo->deleteProduct($product);

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
        $product = $this->productRepo->showProduct($id);

        $attributeNames = $this->getAttributes($product->productDetails);

        $parentCategoryId = $this->categoryRepo->getParentCategoryId($product->category_id);
        $rootCategories = $this->categoryRepo->getRootCategories();
        $childCategories = $this->categoryRepo->getChildCategories($parentCategoryId);

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
        $attributes = [
            'name' => $data['name'],
            'weight' => $data['weight'],
            'brand' => $data['brand'],
            'description' => $data['description'],
            'thumbnail' => $this->getThumbnail($product->thumbnail, $data),
            'detail_info' => $data['detail_info'],
            'remaining' => array_sum($data['remaining']),
            'price_range' => $this->priceRange($data['price']),
            'category_id' => $data['category_id'],
        ];

        $this->productRepo->updateProduct($product, $attributes);
    }

    public function prepareUpdateProductDetails($product, $data)
    {
        $existRemaining = array_slice($data['remaining'], 0, $data['currentNumberOfProductDetails']);
        $existPrice = array_slice($data['price'], 0, $data['currentNumberOfProductDetails']);

        $this->productRepo->updateOldProductDetails($data['product_details_ids'], $existRemaining, $existPrice);
        $this->prepareProductDetailInfo($product, $data, $data['currentNumberOfProductDetails']);
    }

    public function updateOldImages($data)
    {
        if (!isset($data['old_image'])) {
            return null;
        }

        return $this->imageRepo->bulkDeleteImages($data['old_image']);
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
            $product = $this->productRepo->find($id);

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
