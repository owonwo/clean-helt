<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer(['all'], function () {
            $guard = '';
            foreach (['doctor', 'patient', 'hospital', 'pharmacy', 'laboratory'] as $sp) {
                if (auth($sp)->check()) {
                    $guard = $sp;
                    break;
                }
            }
            View::share(['guard' => $guard]);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
