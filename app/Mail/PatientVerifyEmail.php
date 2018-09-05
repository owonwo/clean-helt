<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Patient;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PatientVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.patient-verify');
    }
}
