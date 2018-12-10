<?php

namespace App\Providers;

use App\Models\FamilyRecord;
use App\Models\ProfileShare;
use App\Observers\FamilyRecordObserver;
use App\Observers\ProfileShareObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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

        FamilyRecord::observe(FamilyRecordObserver::class);
        ProfileShare::observe(ProfileShareObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
