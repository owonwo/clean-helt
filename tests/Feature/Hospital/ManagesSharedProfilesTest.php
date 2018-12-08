<?php

namespace Tests\Feature\Hospital;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\ProfileShare;
use Carbon\Carbon;
use PhpParser\Comment\Doc;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesSharedProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_hospital_can_view_accepted_shared_profiles()
    {
        $hospital = create(Hospital::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 1
        ]);

        $pending = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 0
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertSee($share->patient->name)
            ->assertDontSee($pending->patient->first_name);
    }

    /** @test */
    public function an_authenticated_hospital_can_view_pending_shared_profiles()
    {
        $hospital = create(Hospital::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 1
        ]);

        $pending = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 0
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/patients/pending')
            ->assertDontSee($share->patient->first_name)
            ->assertSee($pending->patient->first_name);
    }

    /** @test */
    public function an_authenticated_hospital_can_accept_a_profile_share()
    {
        $hospital = create(Hospital::class);
        $profileShare = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->patch("api/hospital/patients/pending/{$profileShare->id}/accept")
            ->assertStatus(200);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $profileShare->id,
            'status' => 1
        ]);

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertSee($profileShare->patient->first_name);
    }

    /** @test */
    public function an_authenticated_hospital_can_only_accept_an_active_profile_share()
    {
        $hospital = create(Hospital::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'expired_at' => Carbon::now()->subDays(2)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->patch("api/hospital/patients/pending/{$share->id}/accept")
            ->assertStatus(400);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $share->id,
            'status' => 0
        ]);

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertDontSee($share->patient->first_name);
    }

    /** @test */
    public function an_authenticated_hospital_can_decline_a_profile_share()
    {
        $hospital = create(Hospital::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->patch("api/hospital/patients/pending/{$share->id}/decline")
            ->assertStatus(200);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $share->id,
            'status' => 2
        ]);

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertDontSee($share->patient->first_name);
    }

    /** @test */
    public function an_authenticated_hospital_can_assign_a_shared_profile_to_their_doctor()
    {
        $hospital = create(Hospital::class);

        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor, ['status' => 1]);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 1
        ]);
        

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->patch("api/hospital/patients/{$share->id}/assign/{$doctor->chcode}");
        

        $this->assertDatabaseHas('profile_shares', [
            'doctor_id' => $doctor->id,
            'provider_id' => $hospital->id,
        ]);
    }
}
