<?php

namespace Tests\Feature\Doctor;

use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\ProfileShare;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorDiagnosesPatientsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_view_all_his_patients()
    {
        $doctor = create(Doctor::class);

        $patientOne = create(Patient::class);
        create(ProfileShare::class, [
            'patient_id' => $patientOne->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->subDays(2)
        ]);

        $patientTwo = create(Patient::class);
        create(ProfileShare::class, [
            'patient_id' => $patientTwo->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->addDays(2)
        ]);

        $this->signIn($doctor, 'doctor');

        $this->makeAuthRequest()
            ->get('/api/doctor/patients')
            ->assertSee($patientTwo->chcode)
            ->assertDontSee($patientOne->chcode);
    }

    /** @test */
    public function a_doctor_can_view_his_patient()
    {
        $doctor = create(Doctor::class);

        $patient = create(Patient::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->addDays(2)
        ]);
       // create(ProfileShare::class,['provider_id' => $doctor->id,'patient_id' => $patient->id]);

        $this->signIn($doctor, 'doctor');

        $this->makeAuthRequest()
            ->get("/api/doctor/patients/{$patient->chcode}")
            ->assertSee($patient->chcode);
    }


    /** @test */
    public function a_doctor_can_give_a_diagnosis_for_his_patient()
    {
        $doctor = create(Doctor::class);

        $patient = create(Patient::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->addDays(2),

        ]);

        $this->signIn($doctor, 'doctor');

        $diagnosis = create(Diagnosis::class)->toArray();
        $data = [
            'quantity' => 5,
            'frequency' =>5,
            'name' => 'Panadol'
        ];
        $labData = [
            'test_name' => 'Drug Test',
            'description' => 'This is the description of the test',
            'result' => 'This is the result of the test',
            'conclusion' => 'We think you have just two weeks to live',
            'status' => 1,
            'taker' => 'Taker',

        ];

        unset($diagnosis['record_id']);
        $this->makeAuthRequest()
            ->post("/api/doctor/patients/{$patient->chcode}/diagnose", array_merge($diagnosis,$data,$labData))
            ->assertStatus(200);

        $this->assertDatabaseHas('diagnoses', $diagnosis);
    }
}
