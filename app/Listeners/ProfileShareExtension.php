<?php

namespace App\Listeners;

use App\Events\ProfileShareExtended;
use App\Notifications\PatientExtendedShare;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileShareExtension
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
     * @param  ProfileShareExtended  $event
     * @return void
     */
    public function handle(ProfileShareExtended $event)
    {
        //
        $event->provider->notify(new PatientExtendedShare($event->patient));
    }
}
