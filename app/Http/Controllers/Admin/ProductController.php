<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'productDetails')->get();

        return view('admin.product.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->load('user', 'category', 'images', 'productDetails');

        return view('admin.product.show', compact('product'));
    }
}
