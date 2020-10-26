<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VoucherRequest;

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
            $data['msg'] = trans('customer.success_add_cart');

            return response()->json($data, config('config.success'));
        }

        $data['msg'] = trans('customer.error_add_cart');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }
}
