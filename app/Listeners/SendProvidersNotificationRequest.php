<?php

namespace App\Listeners;

use App\Events\PatientSharedProfile;
use App\Notifications\PatientProfileSharedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProvidersNotificationRequest
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

        //
    }

    /**
     * Handle the event.
     *
     * @param  PatientSharedProfile  $event
     * @return void
     */
    public function handle(PatientSharedProfile $event)
    {
        //
        $event->provider->notify(new PatientProfileSharedNotification($event->patient,$event->provider));

    }
}
