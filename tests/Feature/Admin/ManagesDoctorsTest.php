<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;




class ManagesDoctorsTest extends TestCase
{
    use RefreshDatabase;


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

        $doctor = create(Doctor::class);

        $this->makeAuthRequest()
            ->get("/api/admin/doctors/{$doctor->chcode}")
            ->assertSee($doctor->first_name);
    }
    /** @test */
    public function an_authenticated_admin_can_deactivate_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);

        $this->makeAuthRequest()->patch("/api/admin/doctors/deactivate/{$doctor->chcode}",[$doctor->profile->active => false]);
        $this->assertDatabaseHas('doctor_profiles',['active' => false]);
    }
    /** @test */
    public function an_authenticated_admin_can_activate_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);

        $this->makeAuthRequest()->patch("/api/admin/doctors/activate/{$doctor->chcode}",['active' => true]);
        $this->assertDatabaseHas('doctor_profiles',['active' => true]);
    }

    /** @test */
    public function an_admin_can_verify_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);

        $this->makeAuthRequest()->patch("/api/admin/doctors/verify/{$doctor->chcode}",['validation' => true]);
        $this->assertDatabaseHas('doctors',['validation' => true]);
    }
    /** @test */
    public function an_admin_can_delete_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);
        $this->makeAuthRequest()->delete("/api/admin/doctors/destroy/{$doctor->chcode}");
        $this->assertDatabaseMissing('doctors',['id' =>$doctor->id]);

    }

    /** @test */
    public function an_admin_can_update_a_doctors_information(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);
        $update = [
            'first_name' => 'Bread'
        ];
        $this->makeAuthRequest()->patch("/api/admin/doctors/update/{$doctor->chcode}",$update);
        $this->assertDatabaseHas('doctors',$update);

    }
}
