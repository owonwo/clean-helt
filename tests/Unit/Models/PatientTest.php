<?php

namespace Tests\Unit\Models;

use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_patient_can_generate_its_own_unique_code()
    {
        $patient = create(Patient::class);
        $this->assertNotNull($patient->chcode);
    }
}
