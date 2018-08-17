<?php

namespace Tests\Unit\Models;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PharmacyTest extends TestCase
{
    use RefreshDatabase;

    private $pharmacy;

    protected function setUp()
    {
        parent::setUp();
        $this->pharmacy = create(Pharmacy::class);
    }

    /** @test */
    public function a_pharmacy_can_generate_its_own_unique_code()
    {
        $this->assertNotNull($this->pharmacy->chcode);
    }

    /** @test */
    public function a_pharmacy_has_many_profile_shares()
    {
        $this->assertInstanceOf(Collection::class, $this->pharmacy->profileShares);
    }

    /** @test */
    public function a_pharmacy_has_many_patients()
    {
        $this->assertInstanceOf(
            Collection::class,
            $this->pharmacy->patients()->get()
        );
    }
}
