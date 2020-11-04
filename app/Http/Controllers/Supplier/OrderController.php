<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class OrderController extends Controller
{
    public function index($status)
    {
        $orders = Order::withTrashed()
            ->where('status', $status)
            ->whereHas('orderItems.productDeltail.product', function (Builder $query) {
                $query->where('user_id', Auth::id());
            })
            ->with('orderItems.productDeltail.product')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('supplier.order.index', compact('orders', 'status'));
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
        $user = $order->user;
        $data = [
            'status' => statusOrder($order->status),
            'class' => classOrder($order->status),
            'icon' => iconOrder($order->status),
            'created_at' => Carbon::now()->toDateTimeString(),
            'order_id' => $order->id,
        ];

        $user->notify(new OrderNotification($data));

        return redirect()->back()->with('message', trans('supplier.change_status_success'));
    }
}
