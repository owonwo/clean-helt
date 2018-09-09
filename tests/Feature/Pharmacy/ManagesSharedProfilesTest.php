<?php

namespace Tests\Feature\Pharmacy;

use App\Models\Pharmacy;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesSharedProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_pharmacy_can_view_accepted_shared_profiles()
    {
        $pharmacy = create(Pharmacy::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => "1"
        ]);

        $pending = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => 0
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get('api/pharmacy/patients')
            ->assertSee($share->patient->first_name)
            ->assertDontSee($pending->patient->first_name);
    }

    /** @test */
    public function an_authenticated_pharmacy_can_view_pending_shared_profiles()
    {
        $pharmacy = create(Pharmacy::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => 1
        ]);

        $pending = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => 0
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get('api/pharmacy/patients/pending')
            ->assertDontSee($share->patient->first_name)
            ->assertSee($pending->patient->first_name);
    }

    /** @test */
    public function an_authenticated_pharmacy_can_accept_a_profile_share()
    {
        $pharmacy = create(Pharmacy::class);
        $profileShare = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->patch("api/pharmacy/patients/pending/{$profileShare->id}/accept")
            ->assertStatus(200);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $profileShare->id,
            'status' => 1
        ]);

        $this->makeAuthRequest()
            ->get('api/pharmacy/patients')
            ->assertSee($profileShare->patient->first_name);
    }

    /** @test */
    public function an_authenticated_pharmacy_can_only_accept_an_active_profile_share()
    {
        $pharmacy = create(Pharmacy::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'expired_at' => Carbon::now()->subDays(2)
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->patch("api/pharmacy/patients/pending/{$share->id}/accept")
            ->assertStatus(400);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $share->id,
            'status' => 0
        ]);

        $this->makeAuthRequest()
            ->get('api/pharmacy/patients')
            ->assertDontSee($share->patient->first_name);
    }

    /** @test */
    public function an_authenticated_pharmacy_can_decline_a_profile_share()
    {
        $pharmacy = create(Pharmacy::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->patch("api/pharmacy/patients/pending/{$share->id}/decline")
            ->assertStatus(200);

        $this->assertDatabaseHas('profile_shares', [
            'id' => $share->id,
            'status' => "2"
        ]);

        $this->makeAuthRequest()
            ->get('api/pharmacy/patients')
            ->assertDontSee($share->patient->first_name);
    }
}
