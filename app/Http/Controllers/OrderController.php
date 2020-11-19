<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class OrderController extends Controller
{
    public function increaseProductRemaining($order)
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

        foreach ($order->orderItems as $orderItem) {
            $productDetail['ids'][] = $orderItem->product_detail_id;
            $productDetail['remains'][] = $orderItem->productDeltail->remaining + $orderItem->quantity;
            $productDetail['cases'][] = "WHEN {$orderItem->product_detail_id} then ?";

            $position = array_search($orderItem->productDeltail->product_id, $product['ids']);
            if ($position) {
                $product['remains'][$position] += $orderItem->quantity;
            } else {
                $product['ids'][] = $orderItem->productDeltail->product_id;
                $product['remains'][] = $orderItem->productDeltail->product->remaining + $orderItem->quantity;
                $product['cases'][] = "WHEN {$orderItem->productDeltail->product_id} then ?";
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

    public function dropOrder($requestData)
    {
        DB::beginTransaction();
        try {
            $order = Order::with('orderItems.productDeltail.product')->findOrFail($requestData['order_id']);
            $order->update(['status' => $requestData['order_status']]);
            if ($order->voucher_id) {
                Voucher::find($order->voucher_id)->increment('quantity');
            }
            $this->increaseProductRemaining($order);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return false;
        }

        return true;
    }

    public function refuseOrder(Request $request)
    {
        if ($this->dropOrder($request->all())) {
            Alert::success(trans('sentences.refuse_order_successfully'));
        } else {
            Alert::error(trans('sentences.cannot_refuse_order'));
        }

        return redirect()->route('orders.show', $request->order_id);
    }

    public function cancelOrder(Request $request)
    {
        if ($this->dropOrder($request->all())) {
            Alert::success(trans('sentences.cancel_order_successfully'));
        } else {
            Alert::error(trans('sentences.cannot_cancel_order'));
        }

        return redirect()->route('home.order');
    }
}
