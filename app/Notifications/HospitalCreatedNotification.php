<?php

namespace App\Notifications;

use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HospitalCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $password;

    private $hospital;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Hospital $hospital, $password)
    {
        $this->hospital = $hospital;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("Hello, {$this->hospital->name},")
                    ->line("An account has been created for you on the Clean Helt Platform. Your login details are as follows:")
                    ->line("Email: {$this->hospital->email}")
                    ->line("Password: {$this->password}")
                    ->action('Access the application', url('/'))
                    ->line('Thank you for using Clean Helt!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
