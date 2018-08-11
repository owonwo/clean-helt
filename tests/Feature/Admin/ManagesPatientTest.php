<?php

namespace Tests\Feature\Admin;

use App\Models\Laboratory;
use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesPatientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_admin_can_view_all_registered_patients()
    {
        $laboratory = create(Patient::class);

        $this->signIn(null, 'admin');

        $this->makeAuthRequest()
            ->get('/api/admin/patients')
            ->assertStatus(200)
            ->assertSee($laboratory->name);
    }

    /** @test */
    public function an_authenticated_admin_can_register_patients()
    {
        $this->signIn(null, 'admin');

        $patient = make(Patient::class)->toArray();

        $this->makeAuthRequest()
            ->post('/api/admin/patients', $patient)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get('/api/admin/patients')
            ->assertSee($patient['first_name'])
            ->assertSee($patient['last_name']);
    }

    /** @test */
    public function an_authenticated_admin_can_view_a_registered_patient()
    {
        $this->signIn(null, 'admin');

        $patient = create(Patient::class);

        $this->makeAuthRequest()
            ->get("/api/admin/patients/{$patient->chcode}")

            //that is good
            ->assertSee($patient->first_name);
    }

    /** @test */
    public function an_authenticated_admin_can_update_a_registered_patient()
    {
        $this->signIn(null, 'admin');

        $patient = create(Patient::class);

        $update = [
            'first_name' => "New First Name"
        ];

        $this->makeAuthRequest()
            ->patch("/api/admin/patients/{$patient->chcode}", $update)
            ->assertStatus(200);

        $this->makeAuthRequest()
            ->get("/api/admin/patients/{$patient->chcode}")
            ->assertSee($update['first_name']);
    }

    /** @test */
    public function an_authenticated_admin_can_delete_a_registered_patient()
    {
        $this->signIn(null, 'admin');

        $patient = create(Patient::class);

        $this->makeAuthRequest()
            ->delete("/api/admin/patients/{$patient->chcode}")
            ->assertStatus(200);

        $this->withExceptionHandling()
            ->makeAuthRequest()
            ->get("/api/admin/patients/{$patient->chcode}")
            ->assertDontSee($patient->first_name)
            ->assertStatus(404);
    }

    /** @test */
    public function an_authenticated_admin_can_deactivate_a_patient(){
        $this->signIn(null, 'admin');
        $patient = create(Patient::class);

        $this->makeAuthRequest()->patch("/api/admin/patients/{$patient->chcode}/deactivate", ['active' => false]);
        $this->assertDatabaseHas('patients',['active' => false]);
    }
}
