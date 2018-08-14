<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class DoctorTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $datas = [
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
    }
    /** @test */
    public function a_doctor_can_register()
    {

        $this->withExceptionHandling()->post(route('doctor.create'),$this->datas)->assertStatus(200);
    }
    /** @test */
    public function a_doctor_can_update_his_profile(){
        $doctor  = create('App\Models\Doctor');
        $this->signIn($doctor,'doctor');
        $this->withExceptionHandling()->patch(route('doctor.update',$doctor))->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_create_a_diagnosis(){
        $doctor = create('App\Models\Doctor');
        $patient = create('App\Models\Patient');

        $record = create('App\Models\MedicalRecord',['issuer_id' => $doctor->id,'patient_id' => $patient->id]);
        $data = [
            'record_id' => $record->id,
            'complaint_history' => 'This is a long complain i dont think it can save to your database',
            'patient_condition' => 1,
            'symptoms' => ['bread','fish','cow'],
            'extras' => 'Anything else youll like to share with us',
            'comments' => 'Dont you have any comments'
        ];

        $this->signIn($doctor,'doctor');

        $this->post(route('doctor.patient.diagnosis',$patient),$data)->assertStatus(200);
    }
    public function a_prescription_is_created_when_a_diagnosis_is_created(){
        $doctor = create('App\Models\Doctor');
        $patient = create('App\Models\Patient');
        $record = create('App\Models\MedicalRecord',['issuer_id' => $doctor->id,'patient_id' => $patient->id]);
        $this->signIn($doctor,'doctor');
        $data = [
            'record_id' => $record->id,
            'complaint_history' => 'This is a long complain i dont think it can save to your database',
            'patient_condition' => 1,
            'symptoms' => ['bread','fish','cow'],
            'extras' => 'Anything else youll like to share with us',
            'comments' => 'Dont you have any comments'
        ];
    }

}
