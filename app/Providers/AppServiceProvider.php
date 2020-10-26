<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.header', function($view) {
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
