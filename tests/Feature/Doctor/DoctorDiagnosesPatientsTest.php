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
        $shareOne = create(ProfileShare::class, [
            'patient_id' => $patientOne->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->subDays(2)
        ]);

        $patientTwo = create(Patient::class);
        $shareTwo = create(ProfileShare::class, [
            'patient_id' => $patientTwo->id,
            'provider_id' => $doctor->id,
            'expired_at' => now()->addDays(2)
        ]);

        $this->signIn($doctor, 'doctor');

        $this->get('/api/doctor/patients')
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

        $this->signIn($doctor, 'doctor');

        $this->get("/api/doctor/patients/{$patient->chcode}")
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
            'expired_at' => now()->addDays(2)
        ]);

        $this->signIn($doctor, 'doctor');

        $diagnosis = make(Diagnosis::class)->toArray();
        unset($diagnosis['record_id']);

        $this->post("/api/doctor/patients/{$patient->chcode}/diagnose", $diagnosis)
            ->assertStatus(200);

        $this->assertDatabaseHas('diagnoses', $diagnosis);
    }
}
