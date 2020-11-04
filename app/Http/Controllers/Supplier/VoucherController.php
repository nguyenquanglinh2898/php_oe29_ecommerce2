<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VoucherRequest;
use App\Http\Requests\EditVoucherRequest;
use RealRashid\SweetAlert\Facades\Alert;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();

        return view('supplier.voucher.index', compact('vouchers'));
    }

    public function destroy(Request $request)
    {
        $deleteVoucher = Voucher::findOrFail($request->input('id'))->delete();
        $vouchers = Voucher::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();

        return view('supplier.voucher.table', compact('vouchers'));
    }

    public function create()
    {
        return view('supplier.voucher.new');
    }

    public function store(VoucherRequest $request)
    {
        if (Voucher::create($request->all())) {
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
        $voucher = Voucher::find($id);
        if($voucher == null){
            Alert::error(trans('supplier.cant_find_voucher'));

            return redirect()->back();
        }

        return view('supplier.voucher.edit', compact('voucher'));
    }

    public function update(EditVoucherRequest $request)
    {
        if (Voucher::findOrFail($request->voucher_id)->update($request->except('voucher_id'))) {
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('supplier.success_edit_voucher');

            return response()->json($data, config('config.success'));
        }

        $data['msg'] = trans('supplier.error_edit_voucher');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }
}
