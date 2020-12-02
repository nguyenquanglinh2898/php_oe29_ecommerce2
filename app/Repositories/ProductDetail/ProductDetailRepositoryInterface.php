<?php
namespace App\Repositories\ProductDetail;

use App\Repositories\RepositoryInterface;

interface ProductDetailRepositoryInterface extends RepositoryInterface
{
    public function showProductDetail($listAttribute, $productId);
}
