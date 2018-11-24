<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DoctorReferralNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $patient;

    public $profileShares;

    public function __construct($patient, $profileShares)
    {
        $this->profileShares = $profileShares;

        $this->patient = $patient;
    }
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'notifiable_type' => $this->profileShares->provider_type,
            'notifiable_id' => $this->profileShares->provider_id,
            'data' => $this->patient->first_name.' '.$this->patient->last_name.' activated you shared profiled.'
        ];
    }
}
