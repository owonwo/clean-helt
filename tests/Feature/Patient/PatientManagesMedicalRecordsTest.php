<?php

namespace Tests\Feature;

use App\Models\Allergy;
use App\Models\HealthInsurance;
use App\Models\Hospitalize;
use App\Models\Immunization;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;



class PatientManagesMedicalRecordsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    private $patient;

    protected function setUp()
    {
        parent::setUp();
        $this->patient = create(Patient::class);
        $this->signIn($this->patient, "patient");
    }
    /** @test */
    public function a_patient_can_add_immunization()
    {
        $record = create(MedicalRecord::class,['type' => 'App\Models\Immunization','issuer_type' => 'App\Models\Patient']);

        $data = [
            'immunization_title' => 'I am the Immunization lord',
            'age' => 20,
            'date_of_immunization' => "2011-18-13",
        ];
        $this->post(route('patient.record.immunization'),$data)->assertStatus(200);
    }

    /** @test */
    public function a_patient_can_update_immunization_record(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\Immunization','issuer_type' => 'App\Models\Patient']);


        $newData = [
            'immunization_title' => 'I am the Immunization Fish',
            'age' => 20,
            'date_of_immunization' => "2011-18-13",
        ];
        $immunization = create(Immunization::class);
        $this->patch(route('patient.update.immunization',$immunization),$newData);
        $this->assertDatabaseHas('immunizations',['immunization_title'=> $newData['immunization_title']]);
    }
    /** @test */
    public function a_patient_can_add_allergy(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\Immunization','issuer_type' => 'App\Models\Patient']);
        $data = [
            'allergy' => "alcohol",
            'reaction' => 'tummy pain',
            'last_occurance' => "2011-18-13"

        ];
        $this->post(route('patient.record.allergy'),$data)->assertStatus(200);
        $this->assertDatabaseHas('allergies',["allergy" =>  "alcohol"]);
    }
    /** @test */
    public function a_patient_can_update_allergy(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\Immunization','issuer_type' => 'App\Models\Patient']);


        $newData = [
            'allergy' => 'Alcohol Allergy',
            'reaction' => 'normal reaction',
            'last_occurance' => "2011-18-13",
        ];
        $allergy = create(Allergy::class);
        $this->patch(route('patient.update.allergy',$allergy),$newData);
        $this->assertDatabaseHas('allergies',['allergy'=> $newData['allergy']]);
    }

    /** @test */
    public function a_patient_can_add_health_insurance_medical_records(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\HealthInsurance','issuer_type' => 'App\Models\Patient']);

        $data = [
            'insurance_type' => 'Standard Insurance',
            'company_name' => 'Wigxel Company',
            'address' => '1 khana street Dline',
            'city' => 'Port Harcourt City',
            'phone' => '08118022308',
            'emergency_phone' => '08036735037'
        ];
        $this->post(route('patient.record.health-insurance'),$data)->assertStatus(200);
        $this->assertDatabaseHas('health_insurances',['insurance_type' => $data['insurance_type']]);
    }
    /** @test */
    public function a_patient_can_update_health_insurance(){
            $healthInsurance = create(HealthInsurance::class);
            $data = [
            'insurance_type' => 'Standard Insurance',
            'company_name' => 'Wigxel Company',
            'address' => '1 khana street Dline',
            'city' => 'Port Harcourt City',
            'phone' => '08118022308',
            'emergency_phone' => '08036735037'
             ];
             $this->patch(route('patient.health-insurance.update',$healthInsurance),$data);
             $this->assertDatabaseHas('health_insurances',['insurance_type' => $data['insurance_type']]);
    }
    /** @test */
    public function a_patient_can_add_hospitalization(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\HealthInsurance','issuer_type' => 'App\Models\Patient']);

        $data = [
            'hospitalization_type' => 'Barely Hospitalized',
            'hospital' => 'Juvenial Hospital',
            'doctor' => 'Mebiari is the doctor',
            'reason' => 'He has his reason',
            'complications' => 'Very complicated'
        ];
        $this->post(route('patient.record.hospitalization'),$data)->assertStatus(200);
        $this->assertDatabaseHas('hospitalizes',['hospital' => $data['hospital']]);
    }
    /** @test */
    public function a_patient_can_update_hospitalization(){
        $hospitalize = create(Hospitalize::class);
        $data = [
            'hospital' => 'Bread Hospital'
        ];
        $this->patch(route('patient.update.hospitalize',$hospitalize),$data);
        $this->assertDatabaseHas('hospitalizes',['hospital' => $data['hospital']]);
    }
}
