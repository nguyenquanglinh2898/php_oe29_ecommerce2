<?php

namespace App\Providers;

use App\Repositories\Image\ImageRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Slide;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Product\ProductRepositoryInterface::class,
            \App\Repositories\Product\ProductRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Supplier\SupplierRepositoryInterface::class,
            \App\Repositories\Supplier\SupplierRepository::class
        );

        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Category\CategoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Voucher\VoucherRepositoryInterface::class,
            \App\Repositories\Voucher\VoucherRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Slide\SlideRepositoryInterface::class,
            \App\Repositories\Slide\SlideRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Comment\CommentRepositoryInterface::class,
            \App\Repositories\Comment\CommentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductDetail\ProductDetailRepositoryInterface::class,
            \App\Repositories\ProductDetail\ProductDetailRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Order\OrderRepositoryInterface::class,
            \App\Repositories\Order\OrderRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Image\ImageRepositoryInterface::class,
            \App\Repositories\Image\ImageRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.header', 'supplier.layouts.header'], function($view) {
            $categories = Category::where('parent_id', null)->get();
            if (Auth::check()) {
                $notifications = Auth::user()->unreadNotifications;

                $view->with('notifications', $notifications);
            }

            $view->with('categories', $categories);
        });

        view()->composer('*', function($view) {
            $slides = Slide::orderBy('created_at', 'DESC')->get();

            $view->with('slides', $slides);
        });
    }
}
