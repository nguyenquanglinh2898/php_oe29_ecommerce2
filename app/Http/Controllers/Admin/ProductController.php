<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $products = $this->productRepo->getAllProductOfSupplier();

        return view('admin.product.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->productRepo->find($id);

        return view('admin.product.show', compact('product'));
    }

    public function changeStatus($productId, $statusId)
    {
        $success = $this->productRepo->updateStatus($productId, $statusId);

        if ($success) {
            Alert::success(trans('supplier.change_status_success'));
        } else {
            Alert::error(trans('supplier.change_status_fail'));
        }

        return redirect()->route('admin.products.index');
    }
}
