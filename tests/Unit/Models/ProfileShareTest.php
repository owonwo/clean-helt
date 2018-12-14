<?php

namespace Tests\Unit\Models;

use App\Models\Hospital;
use App\Models\Laboratory;
use App\Models\Pharmacy;
use App\Models\ProfileShare;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Eloquent\Collection;

class ProfileShareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_profile_share_belongs_to_a_patient()
    {
        $share = create(ProfileShare::class);
        $this->assertInstanceOf('App\Models\Patient', $share->patient);
    }

    /** @test */
    public function a_profile_share_can_belong_to_a_doctor()
    {
        $share = create(ProfileShare::class);
        $this->assertInstanceOf('App\Models\Doctor', $share->provider);
    }

    /** @test */
    public function a_profile_share_can_belong_to_a_hospital()
    {
        $hospital = create(Hospital::class);
        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);
        $this->assertInstanceOf('App\Models\Hospital', $share->provider);
    }

    /** @test */
    public function a_profile_share_can_belong_to_a_lab()
    {
        $lab = create(Laboratory::class);
        $share = create(ProfileShare::class, [
            'provider_id' => $lab->id,
            'provider_type' => get_class($lab)
        ]);
        $this->assertInstanceOf('App\Models\Laboratory', $share->provider);
    }

    /** @test */
    public function a_profile_share_can_belong_to_a_pharmacy()
    {
        $pharmacy = create(Pharmacy::class);
        $share = create(ProfileShare::class, [
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy)
        ]);
        $this->assertInstanceOf('App\Models\Pharmacy', $share->provider);
    }

    /** @test */
    public function a_profile_share_has_a_boolean_is_active_attribute()
    {
        $share = create(ProfileShare::class);
        $this->assertTrue(is_bool($share->is_active));
    }
    
    /** @test **/
    public function a_profile_share_can_have_many_extensions()
    {
        $share = create(ProfileShare::class);
        $this->assertInstanceOf(Collection::class, $share->extensions);
    }
}
