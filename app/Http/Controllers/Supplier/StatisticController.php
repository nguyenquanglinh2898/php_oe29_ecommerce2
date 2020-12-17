<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
            $revenues[$month - 1] = ($orderByMonth->sum('total')) - ($orderByMonth->sum('transport_fee'));
        }

        return view('supplier.statistic.month', compact('revenues'));
    }
}
