<?php

namespace Tests\Feature\Laboratory;

use App\Models\Laboratory;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LabProfileShareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_lab_can_view_patient_pending_shares()
    {
        $laboratory = create(Laboratory::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
            'status' => 1
        ]);


        $pending = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
            'status' => 0
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->get('api/laboratories/patient/pending')
            ->assertDontSee($share->patient->first_name)
            ->assertSee($pending->patient->first_name);
    }

    /** @test */

    public  function an_authenticated_laboratory_can_accept_patient_share_for_a_time()
    {
        $laboratory = create(Laboratory::class);

        $profileShare = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
            'expired_at' => Carbon::now()->subDays(2),
            'status' => 1
        ]);
        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->patch("api/laboratories/patient/{$profileShare->id}/accept")
            ->assertStatus(400);

        $this->assertDatabaseHas('profile_shares', ['status'=> 1, 'id' => $profileShare->id]);

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertSee($profileShare->patient->first_name);

    }

    /** @test */
    public function an_authenticated_profile_can_decline_patient_profile_share()
    {
        $laboratory = create(Laboratory::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
            'status' => 1
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->patch("api/laboratories/patient/pending/{$share->id}/decline")
            ->assertStatus(400);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $share->id,
            'status' => 2
        ]);

        $this->makeAuthRequest()
            ->get('api/hospital/patients')
            ->assertDontSee($share->patient->first_name);
    }

    /** @test */
    public function an_authenticated_laboratory_can_view_access_to_share_profile()
    {
        $laboratory = create(Laboratory::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
        ]);

        $pending = create(ProfileShare::class, [
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory),
            'status' => 0
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->get('api/laboratories/patient')
            ->assertSee($share->patient->first_name)
            ->assertDontSee($pending->patient->first_name);
    }
}
