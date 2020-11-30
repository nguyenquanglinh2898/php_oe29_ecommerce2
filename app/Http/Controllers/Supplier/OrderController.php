<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index($status)
    {
        $orders = $this->orderRepo->showSupplierOrders(Auth::id(), $status);

        return view('supplier.order.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $order = $this->orderRepo->showOrder($id);

        return view('supplier.order.show', compact('order'));
    }

    public function changeStatusOrder($id, $status)
    {
        $success = $this->orderRepo->update($id, ['status' => $status]);

        if ($success) {
            Alert::success(trans('supplier.change_status_success'));
        } else {
            Alert::error(trans('supplier.change_status_false'));
        }

        return redirect()->back();
    }
}
