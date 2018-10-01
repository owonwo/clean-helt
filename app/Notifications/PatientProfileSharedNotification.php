<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PatientProfileSharedNotification extends Notification
{
    use Queueable;
    public $patient;
    public $provider;

    /**
     * Create a new notification instance.
     */
    public function __construct(Patient $patient, $provider)
    {
        $this->patient = $patient;
        $this->provider = $provider;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->greeting('Hello '.$this->provider->name)
                    ->line('Clean-Helt (Profile Shares)')
                    ->line($this->patient->first_name.' '.$this->patient->last_name.' shared his profile with you')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->patient->first_name.' '.$this->patient->last_name.' shared his profile with you please accept or ignore',
        ];
    }
}
