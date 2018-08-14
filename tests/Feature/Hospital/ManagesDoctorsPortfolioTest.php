<?php

namespace Tests\Feature\Hospital;

use App\Models\Doctor;
use App\Models\Hospital;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesDoctorsPortfolioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_hospital_can_view_all_her_doctors()
    {
        $hospital = create(Hospital::class);
        $doctor = create(Doctor::class);

        $hospital->doctors()->attach($doctor);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get('api/hospital/doctors')
            ->assertSee($doctor->first_name);
    }
}
