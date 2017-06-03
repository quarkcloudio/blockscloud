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
        // 视图间共享数据

        $navigations = Navigations::query()->orderBy('sort', 'asc')->orderBy('id', 'asc')->where('pid',0)->where('status',1)->get();

        view()->share('navigations',$navigations);
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
