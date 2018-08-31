<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorManagesSharedProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_view_all_pending_patient_profile()
    {
        $doctor = create(Doctor::class);

        $this->signIn($doctor,'doctor-api');

        $this->get(route('doctor.pending.patient'))->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_accept_a_shared_profile()
    {
        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id]);

        $this->patch(route('doctor.accept.patient', ['profileShare' => $profileShare->id]), ['accept' => 1]);
        $this->assertDatabaseHas('profile_shares', ['status' => 1]);
    }

    /** @test */
    public function a_doctor_can_view_patient_profile_by_date()
    {
        $start = Carbon::now();

        $doctor = create(Doctor::class,['created_at' => $start]);
        $this->signIn($doctor,'doctor-api');

        $end = $start->addDay()->format('Y-m-d');
        $this->makeAuthRequest()->get("api/doctor/patients?startDate={$start->format('Y-m-d')}&endDate={$end}")->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_decline_a_shared_profile()
    {
        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id]);
        $this->patch(route('doctor.decline.patient',$profileShare),['decline' => 2]);
        $this->assertDatabaseHas('profile_shares',['status' => 2]);

    }
}
