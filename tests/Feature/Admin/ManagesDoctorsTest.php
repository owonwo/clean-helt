<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class ManagesDoctorsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function an_authenticated_admin_can_view_all_registered_doctors()
    {
        $doctor = create(DoctorProfile::class);

        $this->signIn(null, 'admin');
        $this->makeAuthRequest()
            ->get('/api/admin/doctors')
            ->assertStatus(200)
            ->assertSee($doctor->first_name);
    }
    /** @test */
    public function an_authenticated_admin_can_view_a_registered_doctor()
    {
        $this->signIn(null, 'admin');

        $doctor = create(DoctorProfile::class);

        $this->makeAuthRequest()
            ->get("/api/admin/doctor/{$doctor}")
            ->assertSee($doctor->id);
    }
    /** @test */
    public function an_authenticated_admin_can_deactivate_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(DoctorProfile::class);

        $this->makeAuthRequest()->patchJson("/api/admin/doctors/deactivate/{$doctor->doctors_id}",['active' => false])->assertOk();
    }
    /** @test */
    public function an_admin_can_verify_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(DoctorProfile::class);

        $this->makeAuthRequest()->patchJson("/api/admin/doctors/verify/{$doctor->doctors_id}",['validation' => false])->assertOk();
    }
}
