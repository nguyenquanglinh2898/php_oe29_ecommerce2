<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;

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
}
