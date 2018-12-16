<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientMedicalHistoryTest extends TestCase
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
    public function a_doctor_can_view_client_medical_history()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalHistory']);
        $history = create('App\Models\MedicalHistory', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/medical-history")
            ->assertSee($history->illness)
            ->assertSee($history->date_of_onset);
    }

    /** @test */
    public function a_doctor_can_create_medical_history_for_clients()
    {
        // create a Family Record
        $history = make("App\Models\MedicalHistory")->toArray();
        unset($history['record_id']);
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/medical-history", $history)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\MedicalHistory'
        ];

        
        $this->assertDatabaseHas('medical_histories', $history);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_medical_history()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $history = create('App\Models\MedicalHistory', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['illness' => 'Fever'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/medical-history/$history->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('medical_histories', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_medical_history()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $history = create('App\Models\MedicalHistory', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/medical-history/$history->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('medical_histories', $history->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
