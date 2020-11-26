<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $voucherRepo;

    public function __construct(OrderRepositoryInterface $orderRepo,
                VoucherRepositoryInterface $voucherRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->voucherRepo = $voucherRepo;
    }

    public function dropOrder($requestData)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepo->getOrderDetail($requestData['order_id']);
            $this->orderRepo->updateOrder($order, ['status' => $requestData['order_status']]);
            if ($order->voucher_id) {
                $this->voucherRepo->increseVoucherQuantity($order->voucher_id);
            }
            $this->orderRepo->increaseProductRemaining($order);

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
