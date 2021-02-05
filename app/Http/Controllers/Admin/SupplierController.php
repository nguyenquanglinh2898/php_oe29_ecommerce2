<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Supplier\SupplierRepositoryInterface;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Exception;

class SupplierController extends Controller
{
    protected $supplierRepo;

    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index()
    {
        $suppliers = $this->supplierRepo->getAll();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function supplierRegister()
    {
        $suppliers = $this->supplierRepo->getRegistedSupplier();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function supplierBlock()
    {
        $suppliers = $this->supplierRepo->getBlockedSupplier();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function show($id)
    {
        $supplier = $this->supplierRepo->find($id);

        $postProducts = $this->supplierRepo->getProducts($supplier);

        return view('admin.supplier.show', compact('supplier', 'postProducts'));
    }

    public function changeStatusSupplier($id, $status)
    {
        DB::beginTransaction();
        try {
            $this->supplierRepo->updateStatus($id, $status);

            DB::commit();
            Alert::success(trans('supplier.change_status_success'));

            return redirect()->back()->with('result', 'success');
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('supplier.change_status_false'));
        }

        return redirect()->back()->with('result', 'fail');
    }
}
