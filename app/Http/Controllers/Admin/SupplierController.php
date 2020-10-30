<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Notifications\SupplierNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use DB;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = User::where('role_id', config('config.role_supplier'))
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function supplierRegister()
    {
        $suppliers = User::where('role_id', config('config.role_id'))
            ->where('status', config('config.status_not_active'))
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function supplierBlock()
    {
        $suppliers = User::where('role_id', config('config.role_supplier'))
            ->where('status', config('config.status_block'))
            ->orderBy('created_at', 'DESC')->get();

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function show($id)
    {
        $supplier = User::findOrFail($id);
        $comments = $supplier->comments()
            ->orderBy('created_at', 'DESC')
            ->paginate(config('config.paginate'));

        $postProducts = $supplier->products()
            ->orderBy('created_at', 'DESC')
            ->paginate(config('config.paginate'));

        return view('admin.supplier.show', compact('supplier', 'comments', 'postProducts'));
    }

    public function changeStatusSupplier($id, $status)
    {
        DB::beginTransaction();
        try {
            $supplier = User::findOrFail($id);
            $supplier->update(['status' => $status]);
            $data = [
                'status' => statusSupplier($supplier->status),
                'class' => classSupplier($supplier->status),
                'icon' => iconSupplier($supplier->status),
                'created_at' =>Carbon::now()->toDateTimeString(),
            ];
            if ($status == config('config.status_block')) {
                $supplier->products()->update(['block' => config('config.default_one')]);
            } else {
                $supplier->products()->update(['block' => config('config.default')]);
            }
            $supplier->notify(new SupplierNotification($data));

            DB::commit();
            Alert::success(trans('supplier.change_status_success'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('supplier.change_status_false'));
        }

        return redirect()->back();
    }
}
