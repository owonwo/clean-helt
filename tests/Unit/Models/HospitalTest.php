<?php

namespace Tests\Unit\Models;

use App\Models\Hospital;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HospitalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_hospital_can_generate_its_own_unique_code()
    {
        $hospital = create(Hospital::class);
        $this->assertNotNull($hospital->chcode);
    }
}
