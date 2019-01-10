<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorManagesSharedProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_view_all_pending_patient_profile()
    {
        $doctor = create(Doctor::class);

        $this->signIn($doctor,'doctor-api');

        $this->get(route('doctor.pending.patient'))->assertStatus(200);
    }



    /** @test */
    public function a_doctor_can_accept_a_shared_profile()
    {
        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id]);

        $this->patch(route('doctor.accept.patient', ['profileShare' => $profileShare->id]), ['accept' => 1]);
        $this->assertDatabaseHas('profile_shares', ['status' => 1]);
    }


    /** @test */
    public function a_doctor_can_refer_his_patient_to_another_doctor_that_does_not_belong_to_his_hospital(){

        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id,'status' => 1]);



        $this->get(route('doctor.patient',$patient))->assertSee($patient->first_name);
        //Created the doctor to be refered
        $refferedDoctor = create('App\Models\Doctor');
        //Refer the doctor
        $expiration = Carbon::now()->addDay(1)->format('Y-m-d h:i:s');
        $this->makeAuthRequest()->post(route('doctor.patient.refer',$patient),['chcode' => $refferedDoctor->chcode ,'expiration' => $expiration]);

        //Assert that the patient was referred to another doctor
        $this->assertDatabaseHas('profile_shares',['patient_id' => $patient->id,'provider_id' => $refferedDoctor->id,'provider_type' =>  'App\Models\Doctor']);

    }
    /** @test */
    public function a_doctor_can_refer_his_patient_to_a_doctor_that_works_with_him_in_one_hospital(){
        $hospital = create(Hospital::class);
        $doctor = create(Doctor::class);
        $refferedDoctor = create('App\Models\Doctor');


        $patient = create(Patient::class);
        $hospital->doctors()->attach($doctor, ['status' => 1]);
        $hospital->doctors()->attach($refferedDoctor, ['status' => 1]);
        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id,'status' => 1]);

        $this->get(route('doctor.patient',$patient))->assertSee($patient->first_name);
        //Created the doctor to be refered

        //Refer the doctor
        $expiration = Carbon::now()->addDay(1)->format('Y-m-d h:i:s');
        $this->makeAuthRequest()->post(route('doctor.patient.refer',$patient),['chcode' => $refferedDoctor->chcode ,'expiration' => $expiration,'hospital' => $hospital->chcode]);
        $this->assertDatabaseHas('profile_shares',['patient_id' => $patient->id,'provider_id' => $refferedDoctor->id,'provider_type' =>  'App\Models\Doctor']);
    }

    /** @test */
    public function a_doctor_can_view_his_patients(){
        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id]);

        $this->patch(route('doctor.accept.patient', ['profileShare' => $profileShare->id]), ['accept' => 1]);
        $this->assertDatabaseHas('profile_shares', ['status' => 1]);

        $this->get(route('doctor.patient',$patient))->assertSee($patient->first_name);
    }
    /** @test */
    public function a_doctor_can_view_patient_profile_by_date()
    {
        $start = Carbon::now();
        $doctor = create(Doctor::class,['created_at' => $start]);
        $this->signIn($doctor,'doctor-api');

        $end = $start->addDay()->format('Y-m-d');
        $this->makeAuthRequest()->get("api/doctor/patients?startDate={$start->format('Y-m-d')}&endDate={$end}")->assertStatus(200);
    }

    /** @test */
    public function a_doctor_can_decline_a_shared_profile()
    {
        $doctor = create(Doctor::class);
        $patient = create(Patient::class);

        $this->signIn($doctor,'doctor-api');
        $profileShare = create(ProfileShare::class,['patient_id' => $patient->id,'provider_id' => $doctor->id]);
        $this->patch(route('doctor.decline.patient',$profileShare),['decline' => 2]);
        $this->assertDatabaseHas('profile_shares',['status' => 2]);

    }
}
