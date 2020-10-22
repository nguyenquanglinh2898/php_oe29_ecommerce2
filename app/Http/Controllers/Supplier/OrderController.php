<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', config('config.order_status_pending'))
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('supplier.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $orderItems = $order->orderItems;

        return view('supplier.order.show', compact('orderItems', 'order'));
    }

    public function changeStatusOrder($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(array('status' => $status));

        return redirect()->back()->with('message', trans('supplier.change_status_success'));
    }
}
