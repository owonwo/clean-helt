<?php

namespace Tests\Feature\General;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Pharmacy;
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
    public function anyone_can_access_a_list_of_all_open_entities()
    {
        $doctor = create(Doctor::class);
        $pharmacy = create(Pharmacy::class);
        $hospital = create(Hospital::class);
        $lab = create(Laboratory::class);
        $patient = create(Patient::class);
        $this->get("api/entity")
            ->assertStatus(200)
            ->assertSee($doctor->first_name)
            ->assertSee($pharmacy->name)
            ->assertSee($hospital->name)
            ->assertSee($lab->name)
            ->assertDontSee($patient->first_name);
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
