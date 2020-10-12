<?php

namespace App\Http\Controllers\Supplier;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'productDetails')->get();

        return view('supplier.product.index', compact('products'));
    }

    public function create()
    {
        $rootCategories = Category::where('parent_id', null)->get();

        return view('supplier.product.create', compact('rootCategories'));
    }

    public function getChildCategories($rootCategoryId)
    {
        return Category::where('parent_id', $rootCategoryId)->get();
    }
}
