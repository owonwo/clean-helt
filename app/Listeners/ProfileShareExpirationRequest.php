<?php

namespace App\Listeners;

use App\Events\ProfileShareExpired;
use App\Notifications\ProfileShareExpirationNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileShareExpirationRequest
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
     * @param  ProfileShareExpired  $event
     * @return void
     */
    public function handle(ProfileShareExpired $event)
    {
        //
        $event->provider->notify(new ProfileShareExpirationNotification($event->patient));
    }
}
