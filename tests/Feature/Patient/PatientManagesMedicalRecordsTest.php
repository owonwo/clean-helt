<?php

namespace Tests\Feature;

use App\Models\Allergy;
use App\Models\FamilyRecord;
use App\Models\HealthInsurance;
use App\Models\HospitalContacts;
use App\Models\MedicalHistory;
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
    public function a_patient_can_get_his_allergy(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\Allergy','issuer_type' => 'App\Models\Patient']);
        $data = [
            'allergy' => "alcohol",
            'reaction' => 'tummy pain',
            'last_occurance' => Carbon::now()

        ];
        $this->post(route('patient.record.allergy'),$data)->assertStatus(200);
        $this->assertDatabaseHas('allergies',["allergy" =>  "alcohol"]);

        $this->get(route('patient.get.allergy'))->assertSee($data['allergy']);

    }
    /** @test */
    public function a_patient_can_add_allergy(){
        $record = create(MedicalRecord::class,['type' => 'App\Models\Allergy','issuer_type' => 'App\Models\Patient']);
        $data = [
            'allergy' => "alcohol",
            'reaction' => 'tummy pain',
            'last_occurance' => Carbon::now()

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
     /** @test */
     public function a_patient_can_add_his_medical_history(){
        $data = [
            'illness' => 'Sickness',
            'date_of_onset' => Carbon::now()
        ];      
        $this->post(route('patient.record.history'),$data)->assertStatus(200);
        $this->assertDatabaseHas('medical_histories',['illness' => $data['illness']]);
    
     }
     /** @test */
     public function a_patient_can_update_his_medical_history(){
        $medicalHistory = create(MedicalHistory::class);
        $data = [
            'illness' => 'Sickness',
            'date_of_onset' => Carbon::now()
        ];
        $this->patch(route('patient.update.history',$medicalHistory),$data);
        $this->assertDatabaseHas('medical_histories',['illness' => $data['illness']]);
     }
     /** @test */
     public function a_patient_can_add_family_medical_history(){
        $data = [
            'disease' => 'Malaria',
            'carriers' => ['Brother','Mother'],
            'description' =>  'Lorem ipsum'
        ];
        $this->post(route('patient.record.family'),$data);
        $this->assertDatabaseHas('family_records',['disease' => $data['disease']]);
     }
     /** @test  */
     public function a_patient_can_update_a_family_medical_history(){
         $familyRecord = create(FamilyRecord::class);
         $data = [
             'disease' => 'Malaria',
             'carriers' => ['Brother','Mother'],
             'description' =>  'Lorem ipsum'
         ];
         $this->patch(route('patient.update.family',$familyRecord),$data);
         $this->assertDatabaseHas('family_records',['disease' => $data['disease']]);
     }


    /** @test  */
    public function a_patient_can_delete_a_family_medical_history(){
        $familyRecord = create(FamilyRecord::class);
        $this->delete(route('patient.destroy.family',$familyRecord));
        $this->assertDatabaseMissing('family_records',['id' => $familyRecord->id]);
    }


    /** @test */
    public function  a_patient_can_add_hospital_contact(){
        $data = [
            'name' => 'Hospital of Life',
            'email' => 'yarrowbradley@gmail.com',
            'location' => 'Plot 257 Aba road juncton',
            'phone' => '08118022308'
        ];
        $this->post(route('patient.hospital-contact'),$data);
        $this->assertDatabaseHas('hospital_contacts',['name' => $data['name']]);
    }
    /** @test */
    public function a_patient_can_update_his_hospital_contact(){
        $hospitalContact = create(HospitalContacts::class);
        $newData = [
            'location' => 'Plot 257 Port Harcourt'
        ];
        $this->patch(route('patient.hospital-contact.update',$hospitalContact),$newData);
        $this->assertDatabaseHas('hospital_contacts',['location' => $newData['location']]);
    }
    /** @test */
    public function a_patient_can_delete_his_hospital_contact(){
        $hospitalContact = create(HospitalContacts::class);
        $this->delete(route('patient.hospital-contact.delete',$hospitalContact));
        $this->assertDatabaseMissing('hospital_contacts',['location' => $hospitalContact['location']]);

    }
    /** @test */
    public function a_patient_can_get_hospital_contact(){
        $data = [
            'name' => 'Hospital of Life',
            'email' => 'yarrowbradley@gmail.com',
            'location' => 'Plot 257 Aba road juncton',
            'phone' => '08118022308'
        ];
        $this->post(route('patient.hospital-contact'),$data);
        $this->assertDatabaseHas('hospital_contacts',['name' => $data['name']]);
        $this->get(route('patient.hospital-contact.get'))->assertSee($data['location']);
    }

}
