<?php

namespace App\Providers;


use App\Models\FamilyRecord;
use App\Observers\FamilyRecordObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
