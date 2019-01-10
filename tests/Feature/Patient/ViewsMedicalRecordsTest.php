<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewsMedicalRecordsTest extends TestCase
{
    use RefreshDatabase;
    
    private $patient;
    
    public function setUp()
    {
        parent::setUp();
        $this->patient = create('App\Models\Patient');    
    }
    
    /** @test **/
    public function a_patient_can_view_all_his_medical_records()
    {
        $recordOne = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalHistory']);
        $history = create('App\Models\MedicalHistory', ['record_id' => $recordOne->id]);
        
        $recordTwo = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalCheckup']);
        $checkup = create('App\Models\MedicalCheckup', ['record_id' => $recordTwo->id]);

        $this->signIn($this->patient, 'patient');

        $response = $this->get("api/patient/med-records");
        
        $response->assertSee($history->illness)
                ->assertSee($history->date_of_onset)
                ->assertSee($checkup->title)
                ->assertSee($checkup->summary);
    }
    
    /** @test **/
    public function a_patient_can_view_only_a_specified_subset_of_his_medical_records()
    {
        $recordOne = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalHistory']);
        $history = create('App\Models\MedicalHistory', ['record_id' => $recordOne->id]);
        
        $recordTwo = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalCheckup']);
        $checkup = create('App\Models\MedicalCheckup', ['record_id' => $recordTwo->id]);

        $this->signIn($this->patient, 'patient');

        $response = $this->get("api/patient/med-records?type=checkup");
        
        $response->assertDontSee($history->illness)
                ->assertDontSee($history->date_of_onset)
                ->assertSee($checkup->title)
                ->assertSee($checkup->summary);
    }
    
}
