<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getAllProductOfSupplier();

    public function getFavoriteProducts();

    public function getNewProducts();

    public function getSuggestProducts($categoryId);

    public function searchProduct($keyword);

    public function getCategoriedProduct($category);

    public function filterProduct($category, $condition);

    public function getSupplierProducts($supplierId);

    public function createManyProductDetail($product, $productDetails);

    public function createManyImage($product, $images);

    public function showProduct($productId);

    public function deleteProductDetails($product);

    public function deleteProductImages($product);

    public function deleteProductComments($product);

    public function deleteProduct($product);

    public function updateProduct($product, $attributes = []);

    public function updateOldProductDetails($ids, $remaining, $price);
}
