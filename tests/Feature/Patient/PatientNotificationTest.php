<?php

namespace Tests\Feature\Patient;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public  function a_patient_should_receive_a_notification_when_medical_records_is_created()
    {

        $patient = create(Patient::class);

        $medicalRecord = create(MedicalRecord::class);

        $this->signIn($patient, 'patient');

        //return here after api fixed


    }
}
