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

Route::get('/', function () {
    return view('welcome');
});

Route::get('change-language/{language}', 'LanguageController@index')
    ->name('change_language');

Route::get('logout', 'Authentication@logout')->name('logout');
Route::get('change-password', 'Authentication@changePassword')->name('change_password');

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('products', 'ProductController@index')->name('products.index');
    Route::get('suppliers', 'SupplierController@index')->name('suppliers.index');
    Route::get('statistics', 'StatisticsController@index')->name('statistics.index');
});

Route::prefix('supplier')->name('supplier.')->namespace('Supplier')->group(function(){
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('products', 'ProductController@index')->name('products.index');
    Route::get('products/show/{product}', 'ProductController@show')->name('products.show');
    Route::get('products/create', 'ProductController@create')->name('products.create');
    Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');
    Route::post('products/{product}', 'ProductController@destroy')->name('products.destroy');
    Route::post('products', 'ProductController@store')->name('products.store');
    Route::get('products/get-child-categories/{rootCategory_id}', 'ProductController@getChildCategories')
        ->name('products.get_child_categories');
});
