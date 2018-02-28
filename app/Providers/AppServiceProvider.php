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
        
        if (auth()->check()) {
            $units = Groups::where('is_unit', 1)->pluck('name', 'id');
            view()->share('unitsList', $units);
        }
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
