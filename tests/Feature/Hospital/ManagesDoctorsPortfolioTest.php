<?php

namespace Tests\Feature\Hospital;

use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesDoctorsPortfolioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_hospital_can_view_all_her_doctors()
    {
        $hospital = create(Hospital::class);
        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor, ['status' => 1]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/doctors')
            ->assertSee($doctor->first_name);
    }

    /** @test */
    public function a_hospital_can_send_an_invite_to_a_doctor()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->post("api/hospital/doctors/{$doctor->chcode}/invite");

        $this->assertDatabaseHas('doctor_hospital', [
            'hospital_id' => $hospital->id,
            'doctor_id' => $doctor->id,
            'status' => 0,
            'actor' => get_class($hospital)
        ]);
    }

    /** @test */
    public function a_hospital_can_view_pending_doctor_invites()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);
        $doctorTwo = create(Doctor::class);

        $hospital->doctors()->attach($doctor);
        $hospital->doctors()->attach($doctorTwo, ['actor' => get_class($hospital)]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/doctors/pending")
            ->assertsee($doctor->first_name)
            ->assertDontSee($doctorTwo->first_name);

    }

    /** @test */
    public function a_hospital_can_view_sent_doctor_invites()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);
        $doctorTwo = create(Doctor::class);

        $hospital->doctors()->attach($doctor);
        $hospital->doctors()->attach($doctorTwo, ['actor' => get_class($hospital)]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/doctors/sent")
            ->assertDontsee($doctor->first_name)
            ->assertSee($doctorTwo->first_name);

    }

    /** @test */
    public function a_hospital_can_accept_a_doctors_invite()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/doctors')
            ->assertDontSee($doctor->first_name);

        $this->makeAuthRequest()
            ->patch("api/hospital/doctors/{$doctor->chcode}/accept");

        $this->makeAuthRequest()
            ->get('api/hospital/doctors')
            ->assertSee($doctor->first_name);
    }

    /** @test */
    public function a_hospital_can_decline_a_doctors_invite()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->patch("api/hospital/doctors/{$doctor->chcode}/decline");

        $this->assertDatabaseHas('doctor_hospital', [
            'hospital_id' => $hospital->id,
            'status' => 2,
            'doctor_id' => $doctor->id
        ]);
    }

    /** @test */
    public function a_hospital_can_remove_a_doctor_from_her_portfolio()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor, ['status' => 1]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->delete("api/hospital/doctors/{$doctor->chcode}/delete");

        $this->assertDatabaseMissing('doctor_hospital', [
            'hospital_id' => $hospital->id,
            'doctor_id' => $doctor->id,
            'status' => 1
        ]);
    }
}
