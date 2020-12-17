<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('change-language/{language}', 'LanguageController@index')->name('change_language');

Route::middleware(['auth', 'verified'])->group(function() {

    Route::middleware('checkRole:' . config('setting.admin_id'))->group(function() {
        Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function() {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');
            Route::get('products', 'ProductController@index')->name('products.index');
            Route::get('products/show/{product}', 'ProductController@show')->name('products.show');
            Route::post('products/changeStatus/{product}/{status}', 'ProductController@changeStatus')->name('products.change_status');
            Route::get('statistics', 'StatisticsController@index')->name('statistics.index');
        });

        Route::namespace('Admin')->prefix('admin')->group(function() {
            Route::get('suppliers', 'SupplierController@index')->name('suppliers.index');
            Route::get('suppliers-register', 'SupplierController@supplierRegister')->name('suppliers.register');
            Route::get('suppliers-block', 'SupplierController@supplierBlock')->name('suppliers.block');
            Route::get('suppliers/{id}', 'SupplierController@show')->name('suppliers.show');
            Route::get('suppliers/change-status/{id}/{status}', 'SupplierController@changeStatusSupplier')
                ->name('supplier.change_status');
        });
    });

    Route::middleware('checkRole:' . config('setting.supplier_id'))->group(function() {
        Route::prefix('supplier')->name('supplier.')->namespace('Supplier')->group(function() {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');
            Route::get('products', 'ProductController@index')->name('products.index');
            Route::get('products/show/{product}', 'ProductController@show')->name('products.show');
            Route::get('products/create', 'ProductController@create')->name('products.create');
            Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');
            Route::post('products/{product}/update', 'ProductController@update')->name('products.update');
            Route::post('products/{product}', 'ProductController@destroy')->name('products.destroy');
            Route::post('products', 'ProductController@store')->name('products.store');
            Route::get('products/get-child-categories/{rootCategory_id}', 'ProductController@getChildCategories')
                ->name('products.get_child_categories');
            Route::get('notification/{notification}/{order}', 'NotificationController@show')->name('notifications.show');
            Route::get('monthly-statistic', 'StatisticController@monthStatistic')->name('month.statistic');
        });

        Route::namespace('Supplier')->prefix('supplier')->group(function() {
            Route::get('/orders/{status}', 'OrderController@index')->name('orders.index');
            Route::get('/order-items/{id}', 'OrderController@show')->name('orders.show');
            Route::get('/change-status/{id}/{status}', 'OrderController@changeStatusOrder')
                ->name('orders.change_status');
            Route::get('/vouchers', 'VoucherController@index')->name('voucher.index');
            Route::post('vouchers/destroy/{voucherId}', 'VoucherController@destroy')->name('vouchers.destroy');
            Route::get('/vouchers/create', 'VoucherController@create')->name('voucher.create');
            Route::get('/vouchers/edit/{id}', 'VoucherController@edit')->name('voucher.edit');
            Route::post('vouchers', 'VoucherController@store')->name('voucher.store');
            Route::post('vouchers/update', 'VoucherController@update')->name('voucher.update');
        });

        Route::post('refuse-order', 'OrderController@refuseOrder')->name('order.refuse');
    });

    Route::middleware('checkRole:' . config('setting.customer_id'))->group(function() {
        Route::namespace('Customer')->prefix('cart')->group(function() {
            Route::post('/pay', 'CartController@pay')->name('cart.pay');
        });

        Route::post('cancel-order', 'OrderController@cancelOrder')->name('order.cancel');
    });
});

Route::namespace('Customer')->group(function() {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('checkout', 'CartController@checkout')->name('checkout');
});

Route::namespace('Customer')->prefix('pages')->group(function() {
    Route::get('product/{id}', 'HomeController@show')->name('home.show');
    Route::post('/show-detail', 'HomeController@showDetail')->name('home.show_detail');
    Route::get('/notification/{id}', 'HomeController@notification')->name('home.notification');
    Route::post('search', 'HomeController@search')->name('home.search');
    Route::post('search-detail', 'HomeController@searchDetail')->name('home.search_detail');
    Route::get('category/{id}', 'HomeController@category')->name('home.category');
    Route::get('filter', 'HomeController@filter')->name('home.filter');
    Route::get('orders', 'HomeController@order')->name('home.order');
    Route::get('order-detail/{id}', 'HomeController@orderDetail')->name('home.order_detail');
    Route::get('user', 'HomeController@user')->name('home.user');
    Route::get('user/edit', 'HomeController@editUser')->name('home.edit_user');
    Route::post('user/save', 'HomeController@saveUser')->name('home.save_user');
});

Route::namespace('Customer')->prefix('comment')->group(function () {
    Route::post('comment', 'HomeController@comment')->name('home.comment');
    Route::post('edit', 'HomeController@editComment')->name('home.edit_comment');
    Route::post('delete', 'HomeController@deleteComment')->name('home.delete_comment');
    Route::get('/show-comment/{id}/{productId}', 'HomeController@showComment')->name('comment.show');
    Route::post('reply', 'HomeController@replyComment')->name('home.reply');
    Route::post('edit-reply', 'HomeController@editReplyComment')->name('home.edit_reply');
    Route::post('delete-reply', 'HomeController@deleteReplyComment')->name('home.delete_reply');
});

Route::namespace('Customer')->prefix('cart')->group(function () {
    Route::get('/add', 'CartController@addCart')->name('cart.add');
    Route::post('/update', 'CartController@updateCart')->name('cart.update');
    Route::get('/show', 'CartController@showCart')->name('cart.show');
    Route::post('/remove', 'CartController@removeCart')->name('cart.remove');
    Route::get('/show-detail', 'CartController@showDetailCart')->name('cart.show_detail');
    Route::get('/transporter-fee/{transporterId}', 'CartController@transporterFee')->name('cart.transporter_fee');
    Route::get('/show-vouchers', 'CartController@showSupplierVouchers')->name('cart.show_supplier_vouchers');
    Route::get('/check-voucher', 'CartController@checkVoucher')->name('cart.check_voucher');
});

Route::namespace('Supplier')->group(function() {
    Route::get('get-child-categories/{root_category_id}', 'ProductController@getChildCategories')
        ->name('get_child_categories');
});

Auth::routes(['verify' => true]);
