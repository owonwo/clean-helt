<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class PatientTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_patient_can_view_his_medical_records()
    {
        $patient = create('App\Models\Patient');
        $this->signIn($patient, 'patient');
        $this->makeAuthRequest()->get("api/patient/".$patient->id."/medical-records")->assertStatus(200);
    }
}
