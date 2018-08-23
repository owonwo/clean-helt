<?php

namespace Tests\Unit\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    private $doctor;

    protected function setUp()
    {
        parent::setUp();
        $this->doctor = create(Doctor::class);
    }

    /** @test */
    public function a_doctor_can_generate_its_own_unique_code()
    {
        $this->assertNotNull($this->doctor->chcode);
    }

    /** @test */
    public function a_doctor_has_many_profile_shares()
    {
        $this->assertInstanceOf(Collection::class, $this->doctor->profileShares);
    }
    /** @test */
    public function a_doctor_belongs_to_many_hospital(){
        $this->assertInstanceOf(Collection::class,$this->doctor->hospitals);
    }
}
