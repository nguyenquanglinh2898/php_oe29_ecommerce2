<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Transporter;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Cart;
use Illuminate\Support\Arr;
use Session;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $item = ProductDetail::with('product')->findOrFail($request->product_detail_id)->toArray();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        if (!$cart->add($item)) {
            $data['msg'] = trans('customer.error_add_cart');
            $data['error'] = trans('customer.error');

            return response()->json($data, config('config.error'));
        }
        else {
            Session::put('cart', $cart);
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('customer.success_add_cart');
        }

        return response()->json($data, config('config.success'));
    }

    public function updateCart(Request $request)
    {
        $item = ProductDetail::with('product')->findOrFail($request->input('id'))->toArray();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        if (!$cart->update($item, $request->input('qty'))) {
            $data['msg'] = trans('customer.error_update_cart');
            $data['error'] = trans('customer.error');

            return response()->json($data, config('config.error'));
        }
        else {
            Session::put('cart', $cart);
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('customer.success_add_cart');
            $data['total_price_item'] = $item['price'] * $request->input('qty');
            $data['totalPrice'] = $cart->totalPrice;
            $data['totalQty'] = $cart->totalQty;
            $data['key'] = $request->input('id');
        }

        return response()->json($data, config('config.success'));
    }

    public function removeCart(Request $request)
    {
        $item = ProductDetail::with('product')->findOrFail($request->input('id'))->toArray();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (!$cart->remove($item)) {
            $data['msg'] = trans('customer.remove_cart');
            $data['error'] = trans('customer.error');

            return response()->json($data, config('config.error'));
        }
        else if($cart->items) {
            Session::put('cart', $cart);
            $data['msg'] = trans('customer.success_remove_cart');
            $data['success'] = trans('customer.success');
            $data['totalPrice'] = $cart->totalPrice;
            $data['totalQty'] = $cart->totalQty;
            $data['key'] = $request->input('id');
        } else {
            Session::forget('cart');
            $cart = null;
            $data['msg'] = trans('customer.success_remove_cart');
            $data['success'] = trans('customer.success');
        }

        if ($request->has('remove')) {

            return view('layouts.cart_detail', compact('cart'));
        }

        return response()->json($data, config('config.success'));
    }

    public function showCart()
    {
        return view('layouts.minicart');
    }

    public function showDetailCart()
    {
        $cart = Session::get('cart');

        return view('pages.cart', compact('cart'));
    }

    public function checkout()
    {
        $paymentMethods = PaymentMethod::all();
        $transporters = Transporter::all();
        $cart = Session::get('cart');

        $checkout = [];
        $checkout['suppliers'] = $this->groupOrderItem($cart);
        $checkout['totalQuantity'] = $cart->totalQty;
        $checkout['totalPrice'] = $cart->totalPrice;
        $checkout['totalWeight'] = $cart->totalWeight;
        Session::put('checkout', $checkout);

        return view('pages.checkout', compact('checkout', 'paymentMethods', 'transporters'));
    }

    public function groupOrderItem($cart)
    {
        $listSupplierWithTheirItems = [];
        foreach ($cart->items as $cartItem) {
            $supplierId = $cartItem['product']['user_id'];
            if (!Arr::exists($listSupplierWithTheirItems, $supplierId)) {
                $supplier['id'] = $supplierId;
                $supplier['name'] = User::findOrFail($supplierId)->name;
                $supplier['items'] = [];
                $supplier['totalWeight'] = $cartItem['product']['weight'] * $cartItem['qty'];
                $supplier['totalPrice'] = $cartItem['price'] * $cartItem['qty'];
                array_push($supplier['items'], $cartItem);

                $listSupplierWithTheirItems = array_add($listSupplierWithTheirItems, $supplierId, $supplier);
            } else {
                $listSupplierWithTheirItems[$supplierId]['totalWeight'] += $cartItem['product']['weight'] * $cartItem['qty'];
                $listSupplierWithTheirItems[$supplierId]['totalPrice'] += $cartItem['price'] * $cartItem['qty'];
                array_push($listSupplierWithTheirItems[$supplierId]['items'], $cartItem);
            }
        }

        return $listSupplierWithTheirItems;
    }

    public function transporterFee($transporterId)
    {
        $transporter = Transporter::findOrFail($transporterId);

        return $transporter->fee;
    }

    public function showSupplierVouchers(Request $request)
    {
        $now = Carbon::now();
        $vouchers = User::findOrFail($request->supplierId)->vouchers()
            ->where([
                ['end_date', '>=', $now],
                ['quantity', '>', 0],
                ['min_value', '<=', $request->totalPrice],
            ])->get();
        $currentVoucherId = $request->currentVoucherId;

        return view('pages.vouchers', compact('vouchers', 'currentVoucherId'));
    }

    public function checkVoucher(Request $request)
    {
        $voucher = Voucher::findOrFail($request->voucherId);
        $shipPrice = $request->shipPrice;
        $totalPrice = $request->totalPrice;

        if ($voucher->freeship) {
            $totalPrice -= $shipPrice;
            $shipPrice = 0;
        }

        $discount = ((float) $voucher->discount / 100) * $totalPrice;
        $totalPrice -= $discount;

        return compact('shipPrice', 'totalPrice');
    }
}
