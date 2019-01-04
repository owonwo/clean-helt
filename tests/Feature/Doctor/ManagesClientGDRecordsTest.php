<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientGDRecordsTest extends TestCase
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
    public function a_doctor_can_view_client_gd_record()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\GDRecord']);
        $gd = create('App\Models\GDRecord', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/gd-records")
            ->assertSee($gd->age)
            ->assertSee($gd->height)
            ->assertSee($gd->weight);
    }

    /** @test */
    public function a_doctor_can_create_gd_records_for_clients()
    {
        // create a Family Record
        $gd = make("App\Models\GDRecord")->toArray();
        unset($gd['record_id']);
        
        $this->signIn($this->doctor, 'doctor');
        $this->post("api/doctor/patients/{$this->patient->chcode}/gd-records", $gd)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\GDRecord'
        ];

        
        $this->assertDatabaseHas('g_d_records', $gd);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_gd_record()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $gd = create('App\Models\GDRecord', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['weight' => '200'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/gd-records/$gd->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('g_d_records', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_gd_record()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $gd = create('App\Models\GDRecord', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/gd-records/$gd->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('g_d_records', $gd->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
