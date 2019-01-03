<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientMedicationsTest extends TestCase
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
    public function a_doctor_can_view_client_medications()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\Medication']);
        $medication = create('App\Models\Medication', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/medications")
            ->assertSee($medication->name)
            ->assertSee($medication->date);
    }

    /** @test */
    public function a_doctor_can_create_medication_for_clients()
    {
        // create a Family Record
        $medication = make("App\Models\Medication")->toArray();
        unset($medication['record_id']);
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/medications", $medication)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\Medication'
        ];

        
        $this->assertDatabaseHas('medications', $medication);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_medication()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $medication = create('App\Models\Medication', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['name' => 'Paracetamol'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/medications/$medication->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('medications', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_medication()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $medication = create('App\Models\Medication', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/medications/$medication->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('medications', $medication->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
