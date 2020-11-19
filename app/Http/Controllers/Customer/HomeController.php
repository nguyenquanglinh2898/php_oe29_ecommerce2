<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transporter;
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
use App\Models\Comment;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\CommentNotification;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $favoriteProducts = Product::join('comments', 'products.id', '=', 'comments.product_id')
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

        $newProducts = Product::active()->orderBy('created_at', 'DESC')->paginate(config('config.paginate'));
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

        if ($productDetails[config('config.default')]->list_attributes != null) {
            foreach ($productDetails as $detail) {
                $listAttributes->push(json_decode($detail->list_attributes));
            }

            foreach ($listAttributes[config('config.default')] as $key => $value) {
                $groupAtribute[$key] = array_unique(data_get($listAttributes, '*.' . $key));
            }

            $activeAttribute = (array) json_decode($productDetails[config('config.default')]->list_attributes);
        }

        $activeAttribute['price'] = $productDetails[config('config.default')]->price;
        $activeAttribute['remaining'] = $productDetails[config('config.default')]->remaining;
        $activeAttribute['id'] = $productDetails[config('config.default')]->id;

        $activeComment = null;
        $comments = $product->comments()->where('parent_id', null)->get();
        if (Auth::check()) {
            $activeComment = Auth::user()->comments()->where('product_id', $product->id)->where('parent_id', null)->first();
        }

        return view('pages.product', compact('product', 'groupAtribute', 'activeAttribute', 'suggestProducts', 'activeComment', 'comments'));

    }

    public function showDetail(Request $request)
    {
        $productDetails = ProductDetail::where('list_attributes', json_encode($request->except(['product_id', '_token']), JSON_UNESCAPED_UNICODE))
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
            $products = Product::active()->where('name', 'LIKE', "%$keyword%")->get();

            return view('layouts.search', compact('products'));
        }
    }

    public function searchDetail(Request $request)
    {
        $keyword = $request->input('name');

        if ($keyword != null) {

            $products = Product::active()->where('name', 'LIKE', "%$keyword%")->get();
            $categories = Category::with('products')->where('name', 'LIKE', "%$keyword%")->take(config('config.take'))->get();

            return view('pages.search', compact('products', 'categories'));
        }

        return redirect()->route('home.index');
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('parent_id', $category->id)
                    ->orWhere('id', $category->id);
            })->paginate(config('config.paginate'));

        return view('pages.category', compact('category', 'products'));
    }

    public function filter(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $products = Product::query()->with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('parent_id', $category->id)
                    ->orWhere('id', $category->id);
            })
            ->active()
            ->name($request)
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
        $order = Order::with(['orderItems.productDeltail.product.user', 'transporter', 'voucher'])->findOrFail($id);
        $supplier = $order->orderItems->first()->productDeltail->product->user;

        return view('pages.order', compact('order', 'supplier'));
    }

    public function comment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::create($request->all());
            $rate = Comment::where('product_id', $request->product_id)->where('parent_id', null)->avg('rate');
            $product = Product::findOrFail($request->product_id);
            $product->update(['rate' => $rate]);

            $data = [
                'user' => Auth::user()->name,
                'product_name' => $product->name,
                'comment_id' => $comment->id,
                'product_id' => $request->product_id,
                'rate' => $request->rate,
                'class' => config('config.comment_class'),
                'icon' => config('config.comment_icon'),
                'status' => config('config.comment_status'),
                'created_at' => Carbon::now()->toDateTimeString(),
            ];
            $user = User::findOrFail($product->user_id);
            $user->notify(new CommentNotification($data));

            DB::commit();
            Alert::success(trans('customer.comment_success'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('customer.comment_error'));
        }

        return redirect()->back();
    }

    public function editComment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::findOrFail($request->id)->update($request->except('id'));
            $rate = Comment::where('product_id', $request->product_id)->where('parent_id', null)->avg('rate');
            $product = Product::findOrFail($request->product_id);
            $product->update(['rate' => $rate]);

            DB::commit();
            Alert::success(trans('customer.comment_success'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('customer.comment_error'));
        }

        return redirect()->back();
    }

    public function deleteComment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::findOrFail($request->id)->delete();
            $rate = Comment::where('product_id', $request->product_id)->avg('rate');
            $product = Product::findOrFail($request->product_id);
            $product->update(['rate' => $rate]);

            DB::commit();
            Alert::success(trans('customer.delete_comment_success'));
        } catch (Exception $exception) {
            DB::rollBack();
            Alert::error(trans('customer.comment_error'));
        }

        return redirect()->back();
    }

    public function user()
    {
        return view('pages.show_user');
    }

    public function editUser()
    {
       return view('pages.edit_user');
    }

    public function saveUser(UserRequest $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');

            if ($user->avatar != NULL) {
                Storage::disk('public')->delete('images/' . $user->avatar);
            }

            $user->avatar = $imageName;
        }

        $user->save();
        Alert::success(trans('customer.change_infomation_success'));

        return redirect()->back();
    }

    public function showComment($id, $productId)
    {
        $activeComment = Comment::find($id);

        if ($activeComment) {
            return redirect()->route('home.show', $productId)->with('activeComment', $activeComment);
        }

        Alert::error(trans('customer.comment_has_delete'));

        return redirect()->back();
    }

    public function replyComment(Request $request)
    {
        $comment = Comment::create($request->all());
        $product = Product::findOrFail($request->product_id);
        $comments = $product->comments()->where('parent_id', null)->get();

        return view('layouts.comment', compact('product', 'comments'));
    }

    public function editReplyComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id)->update($request->except('id'));
        $product = Product::findOrFail($request->product_id);
        $comments = $product->comments()->where('parent_id', null)->get();

        return view('layouts.comment', compact('product', 'comments'));
    }

    public function deleteReplyComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id)->delete();
        $product = Product::findOrFail($request->product_id);
        $comments = $product->comments()->where('parent_id', null)->get();

        return view('layouts.comment', compact('product', 'comments'));
    }
}
