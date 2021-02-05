<?php
namespace App\Repositories\Supplier;

use App\Models\User;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getAll()
    {
        return $this->model->where('role_id', config('config.role_supplier'))
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getRegistedSupplier()
    {
        return $this->model->where('role_id', config('setting.supplier_id'))
            ->where('status', config('config.status_not_active'))
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getBlockedSupplier()
    {
        return $this->model->where('role_id', config('config.role_supplier'))
            ->where('status', config('config.status_block'))
            ->orderBy('created_at', 'DESC')->get();
    }

    public function getProducts($supplier)
    {
        return $supplier->products()
            ->orderBy('created_at', 'DESC')
            ->paginate(config('config.paginate'));
    }

    public function updateStatus($id, $status)
    {
        $supplier = $this->find($id);
        if ($supplier) {
            $supplier->update(['status' => $status]);
            $supplier->products()->update(['status' => $status]);

            return $supplier;
        }

        return false;
    }
}
