<?php

namespace Tests\Feature;

use App\Events\VerifyDoctor;
use App\Mail\DoctorVerificationEmail;
use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Support\Facades\Mail;
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

        create(DoctorProfile::class, ['doctors_id' => $doctor->id]);

        $this->makeAuthRequest()->patch("/api/admin/doctors/deactivate/{$doctor->chcode}",[$doctor->profile->active => false]);
        $this->assertDatabaseHas('doctor_profiles',['active' => false]);
    }
    /** @test */
    public function an_authenticated_admin_can_activate_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);
        $doctorProfile = create(DoctorProfile::class,['doctors_id' => $doctor->id]);
        $this->makeAuthRequest()->patch(route('admin.doctor.activate',$doctor),['active' => true]);
        $this->assertDatabaseHas('doctor_profiles',['active' => true]);
    }

    /** @test */
    public function an_admin_can_verify_a_doctor(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);
        $doctorProfile = create(DoctorProfile::class,['doctors_id' => $doctor->id]);
        $this->makeAuthRequest()->patch("/api/admin/doctors/verify/{$doctor->chcode}",['validation' => true]);
        $this->assertDatabaseHas('doctors',['validation' => true]);
    }
    /** @test */
    public function an_email_is_sent_to_doctor_after_verification(){
        $this->signIn(null, 'admin');
        $doctor = create(Doctor::class);

        $this->makeAuthRequest()->patch("/api/admin/doctors/verify/{$doctor->chcode}",['validation' => true]);
        $this->assertDatabaseHas('doctors',['validation' => true]);
        Mail::fake();
        event(new VerifyDoctor($doctor));
        Mail::assertSent(DoctorVerificationEmail::class);

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
