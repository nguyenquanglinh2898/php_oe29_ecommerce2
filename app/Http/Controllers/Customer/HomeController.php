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
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();

        return Auth::user()->unreadNotifications()->count();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('name');

        if ($keyword != null) {
            $products = Product::where('name', 'LIKE', "%$keyword%")->get();

            return view('layouts.search', compact('products'));
        }
    }

    public function searchDetail(Request $request)
    {
        $keyword = $request->input('name');

        if ($keyword != null) {

            $products = Product::where('name', 'LIKE', "%$keyword%")->get();
            $categories = Category::with('products')->where('name', 'LIKE', "%$keyword%")->take(config('config.take'))->get();

            return view('pages.search', compact('products', 'categories'));
        }

        return redirect()->route('home.index');
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(config('config.paginate'));

        return view('pages.category', compact('category', 'products'));
    }

    public function filter(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $products = Product::query()
            ->name($request)
            ->category($request)
            ->price($request)
            ->type($request)
            ->paginate(config('config.paginate'));

        return view('pages.category', compact('category', 'products'));
    }

    public function order()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(config('config.paginate'));

        return view('pages.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with(['orderItems', 'user'])->findOrFail($id);

        return view('pages.order', compact('order'));
    }

    public function orderCancel(Request $request)
    {
        $order = Order::findOrFail($request->id);
        if (Carbon::now()->diffInHours($order->created_at) <= config('config.cancel_date') && $order->status == config('config.order_status_pending')) {
            $order->update(['status' => config('config.order_status_cancel')]);
            $data['success'] = trans('customer.success');
            $data['msg'] = trans('customer.cancel_order_success');

            return response()->json($data, config('config.success'));
        }

        $data['msg'] = trans('customer.cancel_order_error');
        $data['error'] = trans('customer.error');

        return response()->json($data, config('config.error'));
    }
}
