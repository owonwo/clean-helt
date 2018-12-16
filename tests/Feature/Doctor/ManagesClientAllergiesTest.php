<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientAllergiesTest extends TestCase
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
        $share = create('App\Models\ProfileShare', ['patient_id' => $this->patient->id]);
        create('App\Models\ShareExtension', [
            'share_id' => $share->id,
            'provider_id' => $this->doctor->id,
            'provider_type' => get_class($this->doctor)
        ]);
    }

    /** @test */
    public function a_doctor_can_view_client_allergies()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\Allergy']);
        $allergy = create('App\Models\Allergy', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/allergies")
            ->assertSee($allergy->allergy)
            ->assertSee($allergy->reactions);
    }

    /** @test */
    public function a_doctor_can_create_allergies_for_clients()
    {
        // create an allergy
        $allergy = make('App\Models\Allergy')->toArray();
        unset($allergy['record_id']);

        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/allergies", $allergy)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\Allergy'
        ];

        $this->assertDatabaseHas('allergies', $allergy);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_allergies()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $allergy = create('App\Models\Allergy', ['record_id' => $record->id]);
       
        $this->signIn($this->doctor, 'doctor');

        $update = ['allergy' => 'Peanut Butter'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/allergies/$allergy->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('allergies', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_allergy()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $allergy = create('App\Models\Allergy', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/allergies/$allergy->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('allergies', $allergy->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
