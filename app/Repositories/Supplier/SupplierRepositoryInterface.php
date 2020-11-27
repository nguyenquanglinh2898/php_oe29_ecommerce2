<?php
namespace App\Repositories\Supplier;

use App\Repositories\RepositoryInterface;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    public function getRegistedSupplier();

    public function getBlockedSupplier();

    public function getProducts($supplier);

    public function updateStatus($id, $status);
}
