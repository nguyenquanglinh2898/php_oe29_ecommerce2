<?php

namespace App\Jobs;

use App\Mail\CommissionsNotify;
use App\Models\User;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToSupplierAskingCommissions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $supplier;

    public function __construct(User $supplier)
    {
        $this->supplier = $supplier;
    }

    public function handle(OrderRepositoryInterface $orderRepo)
    {
        $finishedOrders = $orderRepo->getFinishedOrdersOfThisMonth($this->supplier->id);

        if ($finishedOrders->isNotEmpty()) {
            $monthProfit = $finishedOrders->sum('total') - $finishedOrders->sum('transport_fee');
            $commissions = (int)round($monthProfit * config('setting.commissions_percent'));
            $now = Carbon::now();
            $deadlineDay = (new Carbon('last day of this month'))->toFormattedDateString();

            Mail::to($this->supplier)->send(new CommissionsNotify([
                'monthProfit' => $monthProfit,
                'commissions' => $commissions,
                'now' => $now,
                'deadlineDay' => $deadlineDay,
            ]));
        }
    }
}
