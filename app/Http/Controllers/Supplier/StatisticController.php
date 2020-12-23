<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;

class StatisticController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function monthStatistic()
    {
        $orderByMonths = $this->orderRepo->getOrdersByMonth();

        $revenues = array_fill(0, 12, 0);
        foreach ($orderByMonths as $month => $orderByMonth) {
            $qualifiedOrders = $orderByMonth->filter(function ($order) {
                return $order->status == config('config.order_status_finish') && Carbon::parse($order->created_at)->format('Y') == Carbon::now()->format('Y');
            });

            $revenues[$month - 1] = ($qualifiedOrders->sum('total')) - ($qualifiedOrders->sum('transport_fee'));
        }

        return view('supplier.statistic.month', compact('revenues'));
    }
}
