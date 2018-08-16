<?php

namespace Tests\Unit\Models;

use App\Models\Hospital;
use App\Models\ProfileShare;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HospitalTest extends TestCase
{
    use RefreshDatabase;

    private  $hospital;

    protected function setUp()
    {
        parent::setUp();
        $this->hospital = create(Hospital::class);
    }

    /** @test */
    public function a_hospital_can_generate_its_own_unique_code()
    {
        $this->assertNotNull($this->hospital->chcode);
    }

    /** @test */
    public function a_hospital_has_many_profile_shares()
    {
        $this->assertInstanceOf(Collection::class, $this->hospital->profileShares);
    }

    /** @test */
    public function a_hospital_has_many_patients()
    {
        $this->assertInstanceOf(
            Collection::class,
            $this->hospital->patients()->get()
        );
    }

    /** @test */
    public function a_hospital_belongs_to_many_doctors()
    {
        $this->assertInstanceOf(Collection::class, $this->hospital->doctors);
    }

    /** @test */
    public function a_hospital_might_own_a_profile_share()
    {
        $share = create(ProfileShare::class, [
            'provider_id' => $this->hospital->id,
            'provider_type' => get_class($this->hospital)
        ]);

        $this->assertTrue($this->hospital->ownsShare($share));
    }
}
