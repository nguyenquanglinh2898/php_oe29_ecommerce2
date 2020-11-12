<?php
namespace App\Repositories\Product;

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
}
