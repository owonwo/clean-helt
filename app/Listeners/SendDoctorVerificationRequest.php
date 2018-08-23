<?php

namespace App\Listeners;

use App\Events\VerifyDoctor;
use App\Mail\DoctorVerificationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendDoctorVerificationRequest
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
     * @param  VerifyDoctor  $event
     * @return void
     */
    public function handle(VerifyDoctor $event)
    {
        //
        Mail::to($event->doctor)->send(new DoctorVerificationEmail($event->doctor));
    }
}
