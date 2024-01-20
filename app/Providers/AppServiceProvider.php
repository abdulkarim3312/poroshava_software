<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('bn', array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"));
        View::share('en', array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0"));
    }
}
