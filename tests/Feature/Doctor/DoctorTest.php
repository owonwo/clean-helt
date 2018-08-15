<?php

namespace Tests\Feature;

use App\Models\ProfileShare;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class DoctorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */


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

}
