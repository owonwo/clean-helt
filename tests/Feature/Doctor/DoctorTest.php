<?php

namespace Tests\Feature;

use App\Mail\DoctorConfirmEmail;
use App\Models\Doctor;
use App\Models\ProfileShare;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class DoctorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_register()
    {
        $dataField = [
            'first_name' => 'Bradley',
            'middle_name' => 'Ayibagbalinyun',
            'last_name' => 'Yarrow',
            'email' => 'yarrowbradley@gmail.com',
            'password' => 'Mojanity',
            'phone' => '08118022308',
            'gender' => 'male',
            'specialization' => 'Pediatrician',
            'folio' => 'MD57',
        ];
        $this->post(route('doctor.create'),$dataField)->assertStatus(200);
    }
    /** @test */
    public function a_doctor_can_update_his_profile()
    {
        $doctor  = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $this->withExceptionHandling()->patch(route('doctor.update',$doctor))->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_create_a_diagnosis()
    {
        $doctor = create('App\Models\Doctor');
        $patient = create('App\Models\Patient');

        $record = create('App\Models\MedicalRecord',['issuer_id' => $doctor->id,'patient_id' => $patient->id]);
        $symptoms = ['bread','fish','cow'];
        $data = [
            'record_id' => $record->id,
            'complaint_history' => 'This is a long complain i dont think it can save to your database',
            'patient_condition' => 1,
            'symptoms' => json_encode($symptoms),
            'extras' => 'Anything else youll like to share with us',
            'comments' => 'Dont you have any comments',
            'quantity' => 5,
            'frequency' =>6,
            'name' => 'Paracetamol'
        ];

        $this->signIn($doctor,'doctor');
        // A profile share should be created and a doctor should have access to it before he can perform diagnosis
        create(ProfileShare::class,['provider_id' => $doctor->id,'patient_id' => $patient->id]);

        $this->post(route('doctor.patient.diagnosis',$patient),$data)->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_view_his_profile()
    {
        $doctor = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $this->get(route('doctor.profile',$doctor))->assertSee($doctor->first_name);
    }
    /** @test */
    public function an_email_must_be_sent_upon_registration(){
        Mail::fake();
        event(new Registered(create('App\Models\Doctor')));
        Mail::assertSent(DoctorConfirmEmail::class);
    }
    /** @test */
    public function a_doctor_must_confirm_his_email_address_fully(){
        Mail::fake();
        $this->post(route('doctor.create'),[
            'first_name' =>'Bradley',
            'middle_name' => 'Ayibagbalinyun',
            'last_name' => 'Yarrow',
            'email' => 'yarrowbradley@gmail.com',
            'password' => 'secret',
            'phone' => '08118022308',
            'gender' => 'Male',
            'specialization' => 'cardiologist',
            'folio' => 'MB/12/'.str_random(2),
            'token' => str_random(40),
        ]);
        $doctor = Doctor::whereFirstName('Bradley')->first();

       $this->assertFalse($doctor->confirm);
        $this->assertNotNull($doctor->token);
//
//        dd(route('doctor.register.confirm',['token' => $doctor->token]));
        $this->get(route('doctor.register.confirm',['token' => $doctor->token]))
            ->assertRedirect(route('doctor.profile',$doctor));
        tap($doctor->fresh(),function($doctor){
            $this->assertNull($doctor->token);
              $this->assertTrue($doctor->confirm);
        });
    }

    /** @test */
    public function a_doctor_can_add_hospital(){
        // A doctor inputs or submits the chcode of the hospital
        $doctor = create('App\Models\Doctor');
        $hospital = create('App\Models\Hospital');
        $this->signIn($doctor,'doctor');
        $this->post(route('doctor.addHospital',$doctor),['chcode' => $hospital->chcode])->assertSee($hospital->name);

        $this->assertDatabaseHas('doctor_hospital',['hospital_id' => $hospital->id]);

    }

    /** @test */
    public function a_doctor_can_accept_a_hospital(){
        //
        $doctor = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $hospital = create('App\Models\Hospital');
        $this->makeAuthRequest()
            ->get(route('doctor.hospital.active'))
            ->assertDontSee($hospital);
        $doctor->hospitals()->attach($hospital, ['actor' => get_class($doctor)]);
        $this->makeAuthRequest()->patch(route('doctor.hospital.accept',$hospital->chcode))->assertStatus(200);
        $this->makeAuthRequest()
            ->get(route('doctor.hospital.active'))
            ->assertSee('activeHospital');
    }

    /** @test */
    public function a_doctor_can_reject_a_hospital(){
        $doctor = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $hospital = create('App\Models\Hospital');
        $this->makeAuthRequest()
            ->get(route('doctor.hospital.sent'))
            ->assertDontSee($hospital->name);
        $doctor->hospitals()->attach($hospital, ['actor' => get_class($doctor)]);
        $this->makeAuthRequest()->patch(route('doctor.hospital.decline',$hospital->chcode))->assertStatus(200);
        $this->makeAuthRequest()
            ->get(route('doctor.hospital.sent'))
            ->assertSee('sentHospitals');
    }
    /** @test */
    public function a_doctor_can_remove_a_hospital(){
        $doctor = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $hospital = create('App\Models\Hospital');
        $doctor->hospitals()->attach($hospital, ['actor' => get_class($doctor)]);
        $this->makeAuthRequest()->patch(route('doctor.hospital.accept',$hospital->chcode))->assertStatus(200);
        $this->makeAuthRequest()
            ->get(route('doctor.hospital.active'))
            ->assertSee('activeHospital');
        $this->makeAuthRequest()->patch(route('doctor.hospital.remove',$hospital->chcode))->assertStatus(200);
    }

}
