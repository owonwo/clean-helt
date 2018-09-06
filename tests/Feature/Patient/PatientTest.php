<?php

namespace Tests\Feature;

use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class PatientTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_patient_can_view_his_basic_information()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');
        $this->makeAuthRequest()
            ->get("api/patient/profile")
            ->assertStatus(200);
    }

    /** @test */

    public function a_patient_can_signup_and_use_clean_health()
    {
        $patient = make(Patient::class);

        $this->signIn($patient, 'patient');
        /**
         * passing object convert to array
         *
         */

        $this->makeAuthRequest()
            ->withExceptionHandling()

            ->post('api/patient/register')
            ->assertStatus(200);
    }

    /** @test */
    public function  a_patient_can_update_his_Profile_after_creation()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');

        $updated = [
            'first_name' => $patient->first_name,
        ];

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->patch("api/patient/{$patient->chcode}/patient");
        $this->assertDatabaseHas('patients', $updated);
    }

    /** @test */
    public function  a_patient_can_include_emergency_hospital_to_his_profile()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');

        $updated = [
            'emergency_hospital_address' => $patient->emergency_hospital_address,
        ];

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->patch("api/patient/{$patient->chcode}/emergency");
        $this->assertDatabaseHas('patients', $updated);
    }

    /** @test */
    public function a_patient_can_view_his_medical_records_by_date()
    {
        $patient = create(Patient::class);

        $medical_records = create(MedicalRecord::class,['patient_id' =>  $patient->id]);

        $this->signIn($patient, 'patient');


        $this->makeAuthRequest()
            ->get("api/patient/medical-record/{$patient->chcode}")
            ->assertSee($medical_records->id);
    }

    /** @test */
    public function a_patient_can_view_his_laboratory_test_record()
    {
        $patient = create(Patient::class);

        $labtest = create(LabTest::class, ['record_id' => $patient->id]);
        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get("api/patient/{$patient->chcode}/labtest")
            ->assertSee($labtest->id);
    }

    /** @test */

    public function a_patient_can_view_his_prescription_records_from_pharmarcy_or_doctor()
    {
        $patient = create(Patient::class);

        $prescription = create(Prescription::class, ['record_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get("api/patient/{$patient->chcode}/prescription")
            ->assertSee($prescription->id);
    }

    /** @test */
    public function a_patient_can_view_his_medical_records()
    {
        $patient = create(Patient::class);


        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get("api/patient/".$patient->chcode."/medical-records")
            ->assertStatus(200);
    }
}
