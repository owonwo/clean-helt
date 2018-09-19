<?php

namespace Tests\Feature\General;

use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_access_a_list_of_open_entities()
    {
        $doctor = create(Doctor::class);

        $this->get("api/entity/doctors")
            ->assertStatus(200)
            ->assertSee($doctor->first_name);
    }

    /** @test */
    public function closed_entities_are_not_openly_accessible()
    {
        $patient = create(Patient::class);

        $this->get("api/entity/patients")
            ->assertStatus(404)
            ->assertDontSee($patient->chcode);
    }
}
