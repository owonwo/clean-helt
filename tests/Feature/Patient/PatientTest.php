<?php

namespace Tests\Feature;

use App\Models\Allergy;
use App\Models\FamilyRecord;
use App\Models\LabTest;
use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class PatientTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_patient_can_view_his_basic_information()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');
        $this->makeAuthRequest()
            ->get("api/patient/profile")
            ->assertStatus(200);
    }

    /** @test */

    public function a_patient_can_signup_and_use_clean_health()
    {
        $patient = make(Patient::class);

        $this->signIn($patient, 'patient');
        /**
         * passing object convert to array
         *
         */
//        dd($patient);
        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->post('api/patient/register',$patient)
            ->assertStatus(200);
        $this->assertDatabaseHas('patients', $patient);
    }

    /** @test */
    public function  a_patient_can_update_his_Profile_after_creation()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');

        $updated = [
            'first_name' => $patient->first_name,
        ];

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->patch("api/patient/{$patient->chcode}/patient");
        $this->assertDatabaseHas('patients', $updated);
    }

    /** @test */
    public function  a_patient_can_include_emergency_hospital_to_his_profile()
    {
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');

        $updated = [
            'emergency_hospital_address' => $patient->emergency_hospital_address,
        ];

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->patch("api/patient/{$patient->chcode}/emergency");
        $this->assertDatabaseHas('patients', $updated);
    }


    /** @test */
    public function a_patient_can_view_his_laboratory_test_record()
    {
        $patient = create(Patient::class);

        $labtest = create(LabTest::class, ['record_id' => $patient->id]);
        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get("api/patient/labtest")
            ->assertSee($labtest->id);
    }

    /** @test */

    public function a_patient_can_view_his_prescription_records_from_pharmarcy_or_doctor()
    {
        $patient = create(Patient::class);

        $prescription = create(Prescription::class, ['record_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get("api/patient/prescription")
            ->assertSee($prescription->id);
    }

    /** @test */
    public function a_patient_can_view_his_medical_records()
    {
        $patient = create(Patient::class);
        $record = create(MedicalRecord::class,['type' => 'App\Models\Allergy','issuer_type' => 'App\Models\Patient','issuer_id' => $patient->id,'patient_id' => $patient->id]);
        $record2 = create(MedicalRecord::class,['type' => 'App\Models\FamilyRecord','issuer_type' => 'App\Models\Patient','issuer_id' => $patient->id,'patient_id' => $patient->id]);

        $allergy = create(Allergy::class,['record_id' =>$record->id]);
        $medicalHistory = create(FamilyRecord::class,['record_id' => $record2->id]);


        $this->signIn($patient, 'patient');


        $this->makeAuthRequest()
            ->get("api/patient/medical-records")
            ->assertStatus(200)->assertSee($medicalHistory['description']);
    }
    /** @test */
    public function a_patient_can_register_someone_under_him(){
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');
        $data = [
              "first_name" => "Lew",
              "last_name" => "Rodriguez",
              "middle_name" => "Wyman",
              "avatar" => "http://localhost/storage/avatar/avatar.jpeg",
              "email" => "frank.hayes@example.org",
              "dob" => "2009-11-04",
              "gender" => "male",
              "phone" => "23481180220",
               "password" => "secret",
              "address" => "
                93851 Wiegand Extension\n
                Beattyside, IA 13675-7520
                ",
              "city" => "Runtemouth",
              "state" => "New Eulah",
              "country" => "Indonesia",
              "religion" => "Muslim",
              "marital_status" => "divorced",
              "nok_name" => "Ms. Camila Stark II",
              "nok_email" => "marley02@example.net",
              "nok_phone" => "(890) 949-1618 x8439",
              "nok_address" => ",
                5581 Roob Burg Suite 859\n
                Alberthaville, CA 38803
                ",
              "nok_city" => "Port Arvel",
              "nok_state" => "East Fredbury"

        ];
        /**
         * passing object convert to array
         *
         */

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->post(route('register.child'),$data)
            ->assertStatus(200);
        $this->assertDatabaseHas('patients', ['id' => $patient->id]);
        $this->assertDatabaseHas('linked_accounts',['patient_id' => $patient->id]);
    }
    /** @test */
    public function a_patient_has_children_accounts_linked_to_him(){
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');
        $data = [
            "first_name" => "Lew",
            "last_name" => "Rodriguez",
            "middle_name" => "Wyman",
            "avatar" => "http://localhost/storage/avatar/avatar.jpeg",
            "email" => "frank.hayes@example.org",
            "dob" => "2009-11-04",
            "gender" => "male",
            "phone" => "23481180220",
            "password" => "secret",
            "address" => "
                93851 Wiegand Extension\n
                Beattyside, IA 13675-7520
                ",
            "city" => "Runtemouth",
            "state" => "New Eulah",
            "country" => "Indonesia",
            "religion" => "Muslim",
            "marital_status" => "divorced",
            "nok_name" => "Ms. Camila Stark II",
            "nok_email" => "marley02@example.net",
            "nok_phone" => "(890) 949-1618 x8439",
            "nok_address" => ",
                5581 Roob Burg Suite 859\n
                Alberthaville, CA 38803
                ",
            "nok_city" => "Port Arvel",
            "nok_state" => "East Fredbury"

        ];
        /**
         * passing object convert to array
         *
         */

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->post(route('register.child'),$data)
            ->assertStatus(200);
        $this->assertDatabaseHas('patients', ['id' => $patient->id]);
        $this->assertDatabaseHas('linked_accounts',['patient_id' => $patient->id]);

//        dd($patient->children->first()->account);
//        $patient->children->each(function($child){
//           dd($child->account->createToken(config('app.name'))->accessToken);
//        });

    }
    /** @test */
    public function a_patient_switch_account(){
        $patient = create(Patient::class);

        $this->signIn($patient, 'patient');
        $data = [
            "first_name" => "Lew",
            "last_name" => "Rodriguez",
            "middle_name" => "Wyman",
            "avatar" => "http://localhost/storage/avatar/avatar.jpeg",
            "email" => "frank.hayes@example.org",
            "dob" => "2009-11-04",
            "gender" => "male",
            "phone" => "23481180220",
            "password" => "secret",
            "address" => "
                93851 Wiegand Extension\n
                Beattyside, IA 13675-7520
                ",
            "city" => "Runtemouth",
            "state" => "New Eulah",
            "country" => "Indonesia",
            "religion" => "Muslim",
            "marital_status" => "divorced",
            "nok_name" => "Ms. Camila Stark II",
            "nok_email" => "marley02@example.net",
            "nok_phone" => "(890) 949-1618 x8439",
            "nok_address" => ",
                5581 Roob Burg Suite 859\n
                Alberthaville, CA 38803
                ",
            "nok_city" => "Port Arvel",
            "nok_state" => "East Fredbury"

        ];
        /**
         * passing object convert to array
         *
         */

        $this->makeAuthRequest()
            ->withExceptionHandling()
            ->post(route('register.child'),$data)
            ->assertStatus(200);
        $this->assertDatabaseHas('patients', ['id' => $patient->id]);
        $this->assertDatabaseHas('linked_accounts',['patient_id' => $patient->id]);
        $child = $patient->children->first();

        $this->post(route('switch-account'),$child->account->toArray())->assertStatus(200);

        //we'll send a post to switch account with the patient to be switched
        //Collect the patient and create token for the patient then return the to
    }
}
