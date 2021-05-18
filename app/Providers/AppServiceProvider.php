<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Observers\AdminCategoryObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        Schema::defaultStringLength(191);
        date_default_timezone_set('Europe/Moscow');

        Category::observe(AdminCategoryObserver::class);
    }
}
