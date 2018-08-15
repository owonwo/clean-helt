<?php

namespace Tests\Unit\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    private $patient;

    protected function setUp()
    {
        parent::setUp();
        $this->patient = create(Patient::class);
    }

    /** @test */
    public function a_patient_can_generate_its_own_unique_code()
    {
        $this->assertNotNull($this->patient->chcode);
    }

    /** @test */
    public function a_patient_has_many_profile_shares()
    {
        $this->assertInstanceOf(Collection::class, $this->patient->profileShares);
    }
}
