<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientHealthInsuranceTest extends TestCase
{
    use RefreshDatabase;

    private $doctor, $patient;

    public function setUp()
    {
        parent::setUp();

        // create a doctor
        $this->doctor = create('App\Models\Doctor');
        // create a patient
        $this->patient = create('App\Models\Patient');
        
        // Share profile
        $share = create('App\Models\ProfileShare', ['patient_id' => $this->patient->id]);
        create('App\Models\ShareExtension', [
            'share_id' => $share->id,
            'provider_id' => $this->doctor->id,
            'provider_type' => get_class($this->doctor)
        ]);
    }

    /** @test */
    public function a_doctor_can_view_client_health_insurance()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\HealthInsurance']);
        $insurance = create('App\Models\HealthInsurance', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/health-insurance")
            ->assertSee($insurance->company_name)
            ->assertSee($insurance->phone);
    }

    /** @test */
    public function a_doctor_can_create_health_insurance_for_clients()
    {
        // create a Family Record
        $insurance = make("App\Models\HealthInsurance")->toArray();
        unset($insurance['record_id']);
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/health-insurance", $insurance)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\HealthInsurance'
        ];

        
        $this->assertDatabaseHas('health_insurances', $insurance);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_health_insurance_provider()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $insurance = create('App\Models\HealthInsurance', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['company_name' => 'Serena Williams'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/health-insurance/$insurance->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('health_insurances', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_health_insurance()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $insurance = create('App\Models\HealthInsurance', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/health-insurance/$insurance->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('health_insurances', $insurance->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
