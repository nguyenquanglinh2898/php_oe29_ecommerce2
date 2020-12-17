<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerOrderNotifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayRequest;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transporter;
use App\Models\User;
use App\Models\Voucher;
use App\Notifications\CustomerOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CartController extends Controller
{
    public function addItemToCart($item)
    {
        $cart = new Cart(Session::get('cart'));

        if (Arr::exists($cart->items, $item['id'])) {
            if ($cart->items[$item['id']]['qty'] < $item['remaining']) {
                $items = $cart->items;
                $items[$item['id']]['qty'] = $cart->items[$item['id']]['qty'] + config('setting.default_cart_item_quantity');

                $cart->items = $items;
                $cart->totalQty += config('setting.default_cart_item_quantity');
                $cart->totalPrice += $item['price'];
                $cart->totalWeight += $item['product']['weight'];

                Session::put('cart', $cart);

                return true;
            }

            return false;
        } else {
            Arr::set($item, 'qty', 1);
            $cart->items = Arr::add($cart->items, $item['id'], $item);
            $cart->totalQty += config('setting.default_cart_item_quantity');
            $cart->totalPrice += $item['price'];
            $cart->totalWeight += $item['product']['weight'];

            Session::put('cart', $cart);

            return true;
        }
    }

    public function addCart(Request $request)
    {
        $item = ProductDetail::with('product')->findOrFail($request->product_detail_id)->toArray();

        if (!$this->addItemToCart($item)) {
            $data['msg'] = trans('customer.error_add_cart');
            $data['error'] = trans('customer.error');

            return response()->json($data, config('config.error'));
        }
        else {
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

        if (Arr::exists($cart->items, $item['id'])) {
            if ($request->qty <= $item['remaining'] && $request->qty >= config('setting.default_cart_item_quantity')) {
                $items = $cart->items;
                $items[$item['id']]['qty'] = $request->qty;

                $cart->totalQty += ($request->qty - $cart->items[$item['id']]['qty']);
                $cart->totalPrice += ($request->qty - $cart->items[$item['id']]['qty']) * $item['price'];
                $cart->totalWeight += ($request->qty - $cart->items[$item['id']]['qty']) * $item['product']['weight'];
                $cart->items = $items;

                Session::put('cart', $cart);
                $data['success'] = trans('customer.success');
                $data['msg'] = trans('customer.success_add_cart');
                $data['total_price_item'] = $item['price'] * $request->input('qty');
                $data['totalPrice'] = $cart->totalPrice;
                $data['totalQty'] = $cart->totalQty;
                $data['key'] = $request->input('id');

                return response()->json($data, config('config.success'));
            }
        }

        $data['msg'] = trans('customer.error_update_cart');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }

    public function removeItemFromCart($item)
    {
        $cart = new Cart(Session::get('cart'));

        if (Arr::exists($cart->items, $item['id'])) {
            $items = $cart->items;
            Arr::forget($items, $item['id']);

            $cart->totalQty -= $cart->items[$item['id']]['qty'];
            $cart->totalPrice -= $cart->items[$item['id']]['qty'] * $item['price'];
            $cart->totalWeight -= $cart->items[$item['id']]['qty'] * $item['product']['weight'];
            $cart->items = $items;

            if($cart->items) {
                Session::put('cart', $cart);
            } else {
                Session::forget('cart');
                $cart = null;
            }

            return true;
        }

        return false;
    }

    public function removeCart(Request $request)
    {
        $item = ProductDetail::with('product')->findOrFail($request->input('id'))->toArray();

        if (!$this->removeItemFromCart($item)) {
            $data['msg'] = trans('customer.remove_cart');
            $data['error'] = trans('customer.error');

            return response()->json($data, config('config.error'));
        } else {
            $data['msg'] = trans('customer.success_remove_cart');
            $data['success'] = trans('customer.success');
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
        $voucherPrice = 0;
        $totalPrice = $request->totalPrice;

        if ($voucher->freeship) {
            $totalPrice -= $shipPrice;
            $voucherPrice += $shipPrice;
            $shipPrice = 0;
        }

        $discount = ((float) $voucher->discount / 100) * $totalPrice;
        $totalPrice -= $discount;
        $voucherPrice += $discount;

        return compact('shipPrice', 'voucherPrice', 'totalPrice');
    }

    public function pay(PayRequest $request)
    {
        DB::beginTransaction();
        try {
            $checkout = Session::get('checkout');
            $this->prepareOrders(count($checkout['suppliers']), $request->all());
            $this->prepareOrderItems($checkout['suppliers']);
            $this->notifyToSuppliers($checkout['suppliers'], $request->address);

            DB::commit();

            Session::forget(['cart', 'checkout']);
            Alert::success(trans('sentences.order_successfully'));

            return redirect()->route('home.order');

        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('sentences.order_fail'));

            return redirect()->route('home.index');
        }
    }

    public function notifyToSuppliers($suppliersBasicInfo, $address)
    {
        foreach ($suppliersBasicInfo as $supplierBasicInfo) {
            $supplier = User::findOrFail($supplierBasicInfo['id']);
            $notificationInfo = [
                'message' => trans('sentences.you_have_a_new_order'),
                'products' => $supplierBasicInfo['items'],
                'address' => $address,
                'thumbnail' => config('setting.image_folder') . $supplierBasicInfo['items'][0]['product']['thumbnail'],
            ];

            $supplier->notify(new CustomerOrderNotification($notificationInfo));

            $notificationInfo['route'] = route('supplier.notifications.show', [$supplier->unreadNotifications[0]->id]);

            event(new CustomerOrderNotifyEvent($notificationInfo));
        }
    }

    public function prepareOrders($orderQuantity, $data)
    {
        $orders = [];
        for ($i = 0; $i < $orderQuantity; $i++) {
            $orders[] = [
                'transport_fee' => $data['transport_fee'][$i],
                'voucher_discount' => $data['voucher_discount'][$i],
                'total' => $data['total'][$i],
                'status' => config('config.order_status_pending'),
                'user_id' => Auth::user()->id,
                'voucher_id' => $data['voucher_id'][$i],
                'payment_method_id' => $data['payment_method'],
                'transporter_id' => $data['transporter'],
                'address' => $data['address'],
                'created_at' => Carbon::now(),
            ];
        }
        DB::table('orders')->insert($orders);
        DB::table('vouchers')->whereIn('id', $data['voucher_id'])->decrement('quantity');
    }

    public function prepareOrderItems($suppliers)
    {
        $lastInsertedOrderId = Order::max('id');
        $orderItems = [];
        foreach (array_reverse($suppliers) as $supplier) {
            foreach ($supplier['items'] as $item) {
                $orderItems[] = [
                    'sale_price' => $item['price'],
                    'quantity' => $item['qty'],
                    'order_id' => $lastInsertedOrderId,
                    'product_detail_id' => $item['id'],
                    'created_at' => Carbon::now(),
                ];
            }
            $lastInsertedOrderId--;
        }

        DB::table('order_items')->insert($orderItems);
        $this->decreaseProductRemaining($suppliers);
    }

    public function decreaseProductRemaining($suppliers)
    {
        $productDetail = [
            'ids' => [],
            'remains' => [],
            'cases' => [],
        ];

        $product = [
            'ids' => [],
            'remains' => [],
            'cases' => [],
        ];

        foreach ($suppliers as $supplier) {
            foreach ($supplier['items'] as $item) {
                $productDetail['ids'][] = $item['id'];
                $productDetail['remains'][] = $item['remaining'] - $item['qty'];
                $productDetail['cases'][] = "WHEN {$item['id']} then ?";

                $position = array_search($item['product']['id'], $product['ids']);
                if ($position) {
                    $product['remains'][$position] -= $item['qty'];
                } else {
                    $product['ids'][] = $item['product']['id'];
                    $product['remains'][] = $item['product']['remaining'] - $item['qty'];
                    $product['cases'][] = "WHEN {$item['product']['id']} then ?";
                }
            }
        }

        $productDetail['ids'] = implode(',', $productDetail['ids']);
        $productDetail['cases'] = implode(' ', $productDetail['cases']);
        $product['ids'] = implode(',', $product['ids']);
        $product['cases'] = implode(' ', $product['cases']);

        $productDetailsUpdateQuery = "UPDATE product_details SET `remaining` = CASE `id` {$productDetail['cases']} END WHERE `id` in ({$productDetail['ids']})";
        $productsUpdateQuery = "UPDATE products SET `remaining` = CASE `id` {$product['cases']} END WHERE `id` in ({$product['ids']})";

        DB::update($productDetailsUpdateQuery, $productDetail['remains']);
        DB::update($productsUpdateQuery, $product['remains']);
    }
}
