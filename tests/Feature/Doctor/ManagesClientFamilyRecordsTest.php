<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientFamilyRecordsTest extends TestCase
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
    public function a_doctor_can_view_client_family_records()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\FamilyRecord']);
        $familyRecord = create('App\Models\FamilyRecord', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/family-records")
            ->assertSee($familyRecord->disease)
            ->assertSee($familyRecord->carriers);
    }

    /** @test */
    public function a_doctor_can_create_family_records_for_clients()
    {
        // create a Family Record
        $familyRecord = [
            'disease' => 'Malaria',
            'carriers' => ['Brother','Mother'],
            'description' =>  'Lorem ipsum'
        ];
        
        $this->signIn($this->doctor, 'doctor');

        $this->post("api/doctor/patients/{$this->patient->chcode}/family-records", $familyRecord)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\FamilyRecord'
        ];

        $familyRecord['carriers'] = json_encode($familyRecord['carriers']);
        
        $this->assertDatabaseHas('family_records', $familyRecord);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_family_records()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $familyRecord = create('App\Models\FamilyRecord', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['disease' => 'Polio'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/family-records/$familyRecord->id", $update)
            ->assertStatus(200);

        if (is_array(@$update['carriers'])) {
            $update['carriers'] = json_encode($update['carriers']);
        }
        $this->assertDatabaseHas('family_records', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_family_records()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $familyRecord = create('App\Models\FamilyRecord', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/family-records/$familyRecord->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('family_records', $familyRecord->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
