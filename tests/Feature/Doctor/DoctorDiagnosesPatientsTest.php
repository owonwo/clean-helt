<?php

namespace Tests\Feature\Doctor;

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
}
