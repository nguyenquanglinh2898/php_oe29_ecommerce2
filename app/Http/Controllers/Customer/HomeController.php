<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\ProductDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Models\Notification;
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

    public function show($id)
    {
        $listAttributes = collect();
        $groupAtribute = [];

        $product = Product::findOrFail($id);
        $productDetails = $product->productDetails;

        $suggestProducts = Product::where('category_id', $product->category_id)->get();

        foreach ($productDetails as $detail) {
            $listAttributes->push(json_decode($detail->list_attributes));
        }

        foreach ($listAttributes[config('config.default')] as $key => $value) {
            $groupAtribute[$key] = array_unique(data_get($listAttributes, '*.' . $key));
        }

        $activeAttribute = (array) json_decode($productDetails[config('config.default')]->list_attributes);
        $activeAttribute['price'] = $productDetails[config('config.default')]->price;
        $activeAttribute['remaining'] = $productDetails[config('config.default')]->remaining;
        $activeAttribute['id'] = $productDetails[config('config.default')]->id;

        return view('pages.product', compact('product', 'groupAtribute', 'activeAttribute', 'suggestProducts'));
    }

    public function showDetail(Request $request)
    {
        $productDetails = ProductDetail::where('list_attributes', json_encode($request->except(['product_id'])))
            ->where('product_id', $request->input('product_id'))
            ->get();
        if ($productDetails->isNotEmpty()) {

           return json_encode($productDetails);
        }

        return json_encode(['msg' => trans('customer.no_result')]);
    }

    public function notification($id)
    {
        if (Auth::user()->unreadNotifications->where('id', $id)->markAsRead()) {

            return count(Auth::user()->unreadNotifications);
        }

        return false;
    }
}
