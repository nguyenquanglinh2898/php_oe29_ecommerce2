<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VoucherRequest;
use App\Http\Requests\EditVoucherRequest;
use RealRashid\SweetAlert\Facades\Alert;

class VoucherController extends Controller
{
    protected $voucherRepo;

    public function __construct(VoucherRepositoryInterface $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;
    }

    public function index()
    {
        $vouchers = $this->voucherRepo->getSupplierVouchers(Auth::id());

        return view('supplier.voucher.index', compact('vouchers'));
    }

    public function destroy($voucherId)
    {
        $success = $this->voucherRepo->delete($voucherId);
        if ($success) {
            Alert::success(trans('sentences.delete_successfully'));
        } else {
            Alert::error(trans('sentences.delete_fail'));
        }

        return redirect()->route('voucher.index');
    }

    public function create()
    {
        return view('supplier.voucher.new');
    }

    public function store(VoucherRequest $request)
    {
        if ($this->voucherRepo->create($request->all())) {
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('supplier.success_add_voucher');

            return response()->json($data, config('config.success'));
        }

        $data['msg'] = trans('supplier.error_add_voucher');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }

    public function edit($id)
    {
        $voucher = $this->voucherRepo->find($id);
        if($voucher == null){
            Alert::error(trans('supplier.cant_find_voucher'));

            return redirect()->back();
        }

        return view('supplier.voucher.edit', compact('voucher'));
    }

    public function update(EditVoucherRequest $request)
    {
        $success = $this->voucherRepo->update($request->voucher_id, $request->except('voucher_id'));
        if ($success) {
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('supplier.success_edit_voucher');

            return response()->json($data, config('config.success'));
        }

        $data['msg'] = trans('supplier.error_edit_voucher');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }
}
