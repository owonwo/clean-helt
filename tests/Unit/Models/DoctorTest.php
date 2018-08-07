<?php

namespace Tests\Unit\Models;

use App\Models\Doctor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_generate_its_own_unique_code()
    {
        $doctor = create(Doctor::class);
        $this->assertNotNull($doctor->chcode);
    }
}
