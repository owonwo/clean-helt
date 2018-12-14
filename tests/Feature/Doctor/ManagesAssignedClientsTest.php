<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\ProfileShare;
use App\Models\ShareExtension;
use App\Models\Hospital;

class ManagesAssignedClientsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function a_doctor_can_view_assigned_active_clients()
    {
        $hospital = create(Hospital::class);
        $patient = create(Patient::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 1,
            'patient_id' => $patient->id
        ]);

        $doctor = create(Doctor::class);
        $hospital->doctors()->attach($doctor, ['status' => "1"]);
        
        
        $extension = create(ShareExtension::class, [
            'provider_id' => $doctor->id,
            'provider_type' => get_class($doctor),
            'share_id' => $share->id,
            'sharer_id' => $hospital->id,
            'sharer_type' => get_class($hospital)
        ]);
        
        $this->signIn($doctor, 'doctor');
        
        $this->get(route('doctor.patients'))->assertSee($patient->first_name);
    }
    
    
    /** @test **/
    public function a_doctor_can_view_assigned_active_client()
    {
        $hospital = create(Hospital::class);
        $patient = create(Patient::class);

        $share = create(ProfileShare::class, [
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital),
            'status' => 1,
            'patient_id' => $patient->id
        ]);

        $doctor = create(Doctor::class);
        $hospital->doctors()->attach($doctor, ['status' => "1"]);
        
        
        $extension = create(ShareExtension::class, [
            'provider_id' => $doctor->id,
            'provider_type' => get_class($doctor),
            'share_id' => $share->id,
            'sharer_id' => $hospital->id,
            'sharer_type' => get_class($hospital)
        ]);
        
        $this->signIn($doctor, 'doctor');
        
        $this->get(route('doctor.patient', $patient))->assertSee($patient->first_name);
    }
}
