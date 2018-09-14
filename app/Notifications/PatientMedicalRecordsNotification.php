<?php

namespace App\Notifications;

use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PatientMedicalRecordsNotification extends Notification
{
    use Queueable;


    public $patient;

    public $diagnosis;


    public function __construct(Diagnosis $diagnosis, Patient $patient)
    {
        $this->diagnosis = $diagnosis;
        $this->patient = $patient;
    }



    public function via($notifiable)
    {
        return ['database'];
    }


//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }



    public function toArray($notifiable)
    {
        return [
            'data' => 'You have a new medical record added',
        ];
    }
}
