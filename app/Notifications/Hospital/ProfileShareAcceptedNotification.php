<?php

namespace App\Notifications\Hospital;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\{Hospital, Patient, ProfileShare};

class ProfileShareAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    
    private $reciever;
    
    
    private $profileShare;

    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProfileShare $profileShare, $reciever)
    {
        $this->reciever = $reciever;
        $this->profileShare = $profileShare;
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
        $message =  (new MailMessage);
        
        
        switch(get_class($this->reciever)) {
            case Hospital::class:
                $message = $message->line(
                                "You just accepted a profile share from " . 
                                $this->profileShare->patient->last_name . " " .
                                $this->profileShare->patient->first_name);
                break;
            case Patient::class:
                $message = $message->line(
                        "Your profile share has been accepted by " . 
                        $this->profileShare->provider->name);
        }
        
        return $message->line("Thank you");
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
