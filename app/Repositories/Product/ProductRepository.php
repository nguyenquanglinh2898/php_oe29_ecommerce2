<?php
namespace App\Repositories\Product;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getAllProductOfSupplier()
    {
        return $this->model->with('category', 'productDetails')->get();
    }

    public function find($id)
    {
        return $this->model->with('user', 'category', 'images', 'productDetails')->findOrFail($id);
    }

    public function updateStatus($productId, $statusId)
    {
        return $this->update($productId, ['status' => $statusId]);
    }

    public function getFavoriteProducts()
    {
        return $this->model->join('comments', 'products.id', '=', 'comments.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as catname', DB::raw('SUM(comments.rate) as sumrate'))
            ->groupBy('product_id')
            ->where('products.rate', '>', config('config.rate'))
            ->orderBy('sumrate', 'DESC')
            ->take(config('config.take'))
            ->get();
    }

    public function getNewProducts()
    {
        return $this->model->active()->orderBy('created_at', 'DESC')->paginate(config('config.paginate'));
    }

    public function getSuggestProducts($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    public function searchProduct($keyword)
    {
        return $this->model->active()->where('name', 'LIKE', "%$keyword%")->get();
    }

    public function getCategoriedProduct($category)
    {
        return $this->model->with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('parent_id', $category->id)
                    ->orWhere('id', $category->id);
            })->paginate(config('config.paginate'));
    }

    public function filterProduct($category, $condition)
    {
        return $this->model->query()->with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('parent_id', $category->id)
                    ->orWhere('id', $category->id);
            })
            ->active()
            ->name($condition)
            ->price($condition)
            ->type($condition)
            ->paginate(config('config.paginate'));
    }

    public function getSupplierProducts($supplierId)
    {
        return $this->model->where('user_id', $supplierId)->with('category', 'productDetails')->get();
    }

    public function createManyProductDetail($product, $productDetails)
    {
        return $product->productDetails()->createMany($productDetails);
    }

    public function createManyImage($product, $images)
    {
        return $product->images()->createMany($images);
    }

    public function showProduct($productId)
    {
        return $this->model->with('user', 'category', 'images', 'productDetails')->find($productId);
    }

    public function deleteProductDetails($product)
    {
        return $product->productDetails()->delete();
    }

    public function deleteProductImages($product)
    {
        return $product->images()->delete();
    }

    public function deleteProductComments($product)
    {
        return $product->comments()->delete();
    }

    public function deleteProduct($product)
    {
        return $product->delete();
    }

    public function updateProduct($product, $attributes = [])
    {
        return $product->update($attributes);
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
}
