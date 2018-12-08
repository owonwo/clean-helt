<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientImmunizationsTest extends TestCase
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
    }

    /** @test */
    public function a_doctor_can_view_client_immunizations()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\Immunization']);
        $immunization = create('App\Models\Immunization', ['record_id' => $record->id]);
        create('App\Models\ProfileShare', ['provider_id' => $this->doctor->id, 'patient_id' => $this->patient->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/immunizations")
            ->assertSee($immunization->immunization_title)
            ->assertSee($immunization->age);
    }

    /** @test */
    public function a_doctor_can_create_immunizations_for_clients()
    {
        // create an Immunization
        $immunization = make('App\Models\Immunization')->toArray();
        unset($immunization['record_id']);

        // Share patient's profile with doctor
        create('App\Models\ProfileShare', [
            'provider_id' => $this->doctor->id,
            'patient_id' => $this->patient->id
        ]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/immunizations", $immunization)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\Immunization'
        ];

        $this->assertDatabaseHas('immunizations', $immunization);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_immunizations()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $immunization = create('App\Models\Immunization', ['record_id' => $record->id]);
        create('App\Models\ProfileShare', ['provider_id' => $this->doctor->id, 'patient_id' => $this->patient->id]);

        $this->signIn($this->doctor, 'doctor');

        $update = ['immunization_title' => 'Polio'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/immunizations/$immunization->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('immunizations', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_immunization()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $immunization = create('App\Models\Immunization', ['record_id' => $record->id]);
        create('App\Models\ProfileShare', ['provider_id' => $this->doctor->id, 'patient_id' => $this->patient->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/immunizations/$immunization->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('immunizations', $immunization->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
