<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Navigations;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用基于闭包的composers...
        view()->composer('home.header', function ($view) { 
            $navigations = Navigations::query()->orderBy('sort', 'asc')->orderBy('id', 'asc')->where('pid',0)->where('status',1)->get();
            $view->with('navigations',$navigations);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
