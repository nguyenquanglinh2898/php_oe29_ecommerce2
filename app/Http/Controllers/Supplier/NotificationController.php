<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function show($notificationId, $orderId)
    {
        Auth::user()->unreadNotifications->where('id', $notificationId)->markAsRead();

        $order = $this->orderRepo->showOrder($orderId);

        return view('supplier.order.show', compact('order'));
    }
}
