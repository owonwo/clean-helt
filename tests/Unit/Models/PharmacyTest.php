<?php

namespace Tests\Unit\Models;

use App\Models\Pharmacy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PharmacyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_pharmacy_can_generate_its_own_unique_code()
    {
        $pharmacy = create(Pharmacy::class);
        $this->assertNotNull($pharmacy->chcode);
    }
}
