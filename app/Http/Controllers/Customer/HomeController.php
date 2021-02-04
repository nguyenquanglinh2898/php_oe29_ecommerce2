<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductDetail\ProductDetailRepositoryInterface;
use App\Repositories\Slide\SlideRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UserRequest;
use DB;

class HomeController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $voucherRepo;
    protected $slideRepo;
    protected $commentRepo;
    protected $userRepo;
    protected $productDetailRepo;
    protected $orderRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo,
        VoucherRepositoryInterface $voucherRepo,
        SlideRepositoryInterface $slideRepo,
        CommentRepositoryInterface $commentRepo,
        UserRepositoryInterface $userRepo,
        ProductDetailRepositoryInterface $productDetailRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->voucherRepo = $voucherRepo;
        $this->slideRepo = $slideRepo;
        $this->commentRepo = $commentRepo;
        $this->userRepo = $userRepo;
        $this->productDetailRepo = $productDetailRepo;
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $favoriteProducts = $this->productRepo->getFavoriteProducts();
        $newProducts = $this->productRepo->getNewProducts();
        $newVouchers = $this->voucherRepo->getNewVouchers();
        $slides = $this->slideRepo->getAll();

        return view('pages.home', compact('favoriteProducts', 'newProducts', 'newVouchers', 'slides'));
    }

    public function show($id)
    {
        $listAttributes = collect();
        $groupAtribute = [];

        $product = $this->productRepo->find($id);
        $productDetails = $product->productDetails;

        $suggestProducts = $this->productRepo->getSuggestProducts($product->category_id);

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
        $comments = $this->commentRepo->getProductComments($product);
        if (Auth::check()) {
            $activeComment = $this->userRepo->getUserCommentsOfProduct(Auth::user(), $product->id);
        }

        return view('pages.product', compact('product', 'groupAtribute', 'activeAttribute', 'suggestProducts', 'activeComment', 'comments'));

    }

    public function showDetail(Request $request)
    {
        $productDetails = $this->productDetailRepo->showProductDetail(
            json_encode($request->except(['product_id', '_token']), JSON_UNESCAPED_UNICODE),
            $request->product_id
        );

        if ($productDetails->isNotEmpty()) {
           return json_encode($productDetails);
        }

        return json_encode(['msg' => trans('customer.no_result')]);
    }

    public function notification($id)
    {
        $this->userRepo->markNotiAsRead(Auth::user(), $id);

        return $this->userRepo->getNumberOfUnreadNoti(Auth::user());
    }

    public function search(Request $request)
    {
        if ($request->name) {
            $products = $this->productRepo->searchProduct($request->name);

            return view('layouts.search', compact('products'));
        }

        return false;
    }

    public function searchDetail(Request $request)
    {
        if ($request->name) {
            $products = $this->productRepo->searchProduct($request->name);

            return view('pages.search', compact('products'));
        }

        return redirect()->route('home.index');
    }

    public function category($id)
    {
        $category = $this->categoryRepo->find($id);
        $products = $this->productRepo->getCategoriedProduct($category);

        return view('pages.category', compact('category', 'products'));
    }

    public function filter(Request $request)
    {
        $category = $this->categoryRepo->find($request->category_id);
        $products = $this->productRepo->filterProduct($category, $request);

        return view('pages.category', compact('category', 'products'));
    }

    public function order()
    {
        $orders = $this->orderRepo->getUserOrders(Auth::id());

        return view('pages.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = $this->orderRepo->getOrderDetail($id);
        $supplier = $this->orderRepo->getOrderSupplier($order);

        return view('pages.order', compact('order', 'supplier'));
    }

    public function comment(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->commentRepo->create($request->all());
            $rate = $this->commentRepo->getProductCommentRate($request->product_id);
            $this->productRepo->update($request->product_id, ['rate' => $rate]);

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
            $this->commentRepo->update($request->id, $request->except('id'));
            $rate = $this->commentRepo->getProductCommentRate($request->product_id);
            $this->productRepo->update($request->product_id, ['rate' => $rate]);

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
            $this->commentRepo->delete($request->id);
            $rate = $this->commentRepo->getProductCommentRate($request->product_id);
            $this->productRepo->update($request->product_id, ['rate' => $rate]);

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
        $attributes = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');

            $attributes['avatar'] = $imageName;
        }

        $this->userRepo->update($request->user_id, $attributes);
        Alert::success(trans('customer.change_infomation_success'));

        return redirect()->back();
    }

    public function showComment($id, $productId)
    {
        $activeComment = $this->commentRepo->find($id);

        if ($activeComment) {
            return redirect()->route('home.show', $productId)->with('activeComment', $activeComment);
        }

        Alert::error(trans('customer.comment_has_delete'));

        return redirect()->back();
    }

    public function replyComment(Request $request)
    {
        $this->commentRepo->create($request->all());
        $product = $this->productRepo->find($request->product_id);
        $comments = $this->commentRepo->getProductComments($product);

        return view('layouts.comment', compact('product', 'comments'));
    }

    public function editReplyComment(Request $request)
    {
        $this->commentRepo->update($request->id, $request->except('id'));
        $product = $this->productRepo->find($request->product_id);
        $this->commentRepo->getProductComments($product);

        return view('layouts.comment', compact('product', 'comments'));
    }

    public function deleteReplyComment(Request $request)
    {
        $this->commentRepo->delete($request->id);
        $product = $this->productRepo->find($request->product_id);
        $this->commentRepo->getProductComments($product);

        return view('layouts.comment', compact('product', 'comments'));
    }
}
