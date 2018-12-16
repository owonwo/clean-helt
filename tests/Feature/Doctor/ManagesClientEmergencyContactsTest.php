<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientEmergencyContactsTest extends TestCase
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
    public function a_doctor_can_view_client_emergency_contacts()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\EmergencyContact']);
        $contact = create('App\Models\EmergencyContact', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/emergency-contacts")
            ->assertSee($contact->name)
            ->assertSee($contact->phone);
    }

    /** @test */
    public function a_doctor_can_create_emergency_contacts_for_clients()
    {
        // create a Family Record
        $contact = make("App\Models\EmergencyContact")->toArray();
        unset($contact['record_id']);
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/emergency-contacts", $contact)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\EmergencyContact'
        ];

        
        $this->assertDatabaseHas('emergency_contacts', $contact);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_emergency_contact()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $contact = create('App\Models\EmergencyContact', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['name' => 'Serena Williams'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/emergency-contacts/$contact->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('emergency_contacts', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_emergency_contact()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $contact = create('App\Models\EmergencyContact', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/emergency-contacts/$contact->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('emergency_contacts', $contact->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
