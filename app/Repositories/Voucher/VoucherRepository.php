<?php
namespace App\Repositories\Voucher;

use App\Models\Voucher;
use App\Repositories\BaseRepository;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    public function getModel()
    {
        return Voucher::class;
    }

    public function getNewVouchers()
    {
        return $this->model->orderBy('created_at', 'DESC')->take(config('config.take'))->get();
    }

    public function getSupplierVouchers($supplierId)
    {
        return $this->model->where('user_id', $supplierId)->orderBy('created_at', 'DESC')->get();
    }

    public function increseVoucherQuantity($voucherId)
    {
        return $this->model->find($voucherId)->increment('quantity');
    }
}
