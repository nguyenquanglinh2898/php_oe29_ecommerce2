<?php
namespace App\Repositories\Voucher;

use App\Repositories\RepositoryInterface;

interface VoucherRepositoryInterface extends RepositoryInterface
{
    public function getNewVouchers();

    public function getSupplierVouchers($supplierId);

    public function increseVoucherQuantity($voucherId);
}
