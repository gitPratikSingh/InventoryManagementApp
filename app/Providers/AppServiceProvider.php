<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Groups;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['*'], function ($view) {
            if (auth()->check()) {
                $view->with('unitsList', Groups::where('is_unit', 1)->pluck('name', 'id'));
            }
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
