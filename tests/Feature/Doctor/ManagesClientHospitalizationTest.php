<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagesClientHospitalizationTest extends TestCase
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
    public function a_doctor_can_view_client_hospitalizations()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\Hospitalize']);
        $hospitalization = create('App\Models\Hospitalize', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/hospitalizations")
            ->assertSee($hospitalization->doctor)
            ->assertSee($hospitalization->hospitalization_type);
    }

    /** @test */
    public function a_doctor_can_create_hospitalization_records_for_clients()
    {
        // create Record
        $hospitalization = [
            'hospitalization_type' => 'Barely Hospitalized',
            'hospital' => 'Juvenial Hospital',
            'doctor' => 'Dr. Albert',
            'reason' => 'Leukamia',
            'complications' => 'None'
        ];
        
        $this->signIn($this->doctor, 'doctor');

        $this->post(
                "api/doctor/patients/{$this->patient->chcode}/hospitalizations", 
                $hospitalization
            )
            ->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\Hospitalize'
        ];
        
        $this->assertDatabaseHas('hospitalizes', $hospitalization);
        $this->assertDatabaseHas('medical_records', $medRecord);
    }

    /** @test */
    public function a_doctor_can_edit_client_hospitalization_records()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $hospitalization = create('App\Models\Hospitalize', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['doctor' => 'Abramov Dan'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/hospitalizations/$hospitalization->id", $update)
            ->assertStatus(200);

       
        $this->assertDatabaseHas('hospitalizes', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_hospitalization_records()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $hospitalization = create('App\Models\Hospitalize', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/hospitalizations/$hospitalization->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('hospitalizes', $hospitalization->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
