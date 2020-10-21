<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Cart;
use Session;

class CartController extends Controller
{
    public function addCart($id)
    {
        $item = ProductDetail::with('product')->findOrFail($id)->toArray();
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
}
