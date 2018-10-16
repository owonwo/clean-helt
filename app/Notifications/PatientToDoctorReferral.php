<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PatientToDoctorReferral extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $patient;

    public $refferedDoctor;


    public function __construct($refferedDoctor, $patient)
    {
        $this->refferedDoctor = $refferedDoctor;

        $this->patient = $patient;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'data' => 'Dr '.$this->refferedDoctor->first_name.' '.$this->refferedDoctor->last_name.' was referred to you, do well to accept or decline'
        ];
    }
}
