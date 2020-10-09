<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Voucher;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $favoriteProducts = DB::table('products')
            ->join('comments', 'products.id', '=', 'comments.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as catname', DB::raw('SUM(comments.rate) as sumrate'))
            ->groupBy('product_id')
            ->where('products.rate', '>', config('config.rate'))
            ->orderBy('sumrate', 'DESC')
            ->take(config('config.take'))
            ->get();

        $categories = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.*', DB::raw('COUNT(products.category_id) as sumcat'))
            ->groupBy('category_id')
            ->orderBy('sumcat', 'DESC')
            ->take(config('config.take'))
            ->get();

        $newProducts = Product::orderBy('created_at', 'DESC')->paginate(config('config.paginate'));
        $newVouchers = Voucher::orderBy('created_at', 'DESC')->take(config('config.take'))->get();
        $slides = DB::table('slides')->get();

        return view('pages.home', compact('favoriteProducts', 'newProducts', 'newVouchers', 'categories' , 'slides'));
    }
}
