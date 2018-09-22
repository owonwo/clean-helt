<?php

namespace App\Providers;

use App\Events\NewUserRegistered;
use App\Events\PatientSharedProfile;
use App\Events\ProfileShareExpired;
use App\Events\ProfileShareExtended;
use App\Events\VerifyDoctor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        Registered::class => [
            'App\Listeners\SendEmailConfirmationRequest'
        ],
        VerifyDoctor::class => [
            'App\Listeners\SendDoctorVerificationRequest'
        ],
        PatientSharedProfile::class => [
            'App\Listeners\SendProvidersNotificationRequest'
        ],
        ProfileShareExtended::class => [
            'App\Listeners\ProfileShareExtension'
        ],
        ProfileShareExpired::class => [
            'App\Listeners\ProfileShareExpirationRequest'
        ],
        NewUserRegistered::class => [
            'App\Listeners\NewUserRegisteredRequest'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
