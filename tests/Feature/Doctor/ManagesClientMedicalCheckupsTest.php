<?php

namespace Tests\Feature\Doctor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ManagesClientMedicalCheckupsTest extends TestCase
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
    public function a_doctor_can_view_client_medical_checkups()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id, 'type' => 'App\Models\MedicalCheckup']);
        $checkup = create('App\Models\MedicalCheckup', ['record_id' => $record->id]);

        $this->signIn($this->doctor, 'doctor');

        $this->get("api/doctor/patients/{$this->patient->chcode}/medical-checkups")
            ->assertSee($checkup->title)
            ->assertSee($checkup->report);
    }

    /** @test */
    public function a_doctor_can_create_medical_checkup_for_clients()
    {
        Storage::fake('fakedisk');
        
        // create a Family Record
        $checkup = make("App\Models\MedicalCheckup")->toArray();
        $checkup['report'] = UploadedFile::fake()->create('report.docx');
        unset($checkup['record_id']);
        
        $this->signIn($this->doctor, 'doctor');

        $response = $this->post("api/doctor/patients/{$this->patient->chcode}/medical-checkups", $checkup)->assertStatus(200);

        $medRecord = [
            'issuer_id' => auth()->id(),
            'issuer_type' => get_class(auth()->user()),
            'patient_id' => $this->patient->id,
            'type' => 'App\Models\MedicalCheckup'
        ];

        $check = $response->json()['data'];
        $check['report'] = "checkups/" . basename($check['report']);
        $this->assertDatabaseHas('medical_checkups', $check);
        $this->assertDatabaseHas('medical_records', $medRecord);
        //Storage::disk('fakedisk')->assertExists(basename($check['report']));
    }

    /** @test */
    public function a_doctor_can_edit_client_medical_checkup()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $checkup = create('App\Models\MedicalCheckup', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $update = ['report' => 'Client has Fever'];
        
        $this->patch("api/doctor/patients/{$this->patient->chcode}/medical-checkups/$checkup->id", $update)
            ->assertStatus(200);

        $this->assertDatabaseHas('medical_checkups', $update);
    }

    /** @test */
    public function a_doctor_can_delete_a_clients_medical_checkup()
    {
        $record = create('App\Models\MedicalRecord', ['patient_id' => $this->patient->id]);
        $checkup = create('App\Models\MedicalCheckup', ['record_id' => $record->id]);
        
        $this->signIn($this->doctor, 'doctor');

        $this->delete("api/doctor/patients/{$this->patient->chcode}/medical-checkups/$checkup->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('medical_checkups', $checkup->toArray());
        $this->assertDatabaseMissing('medical_records', $record->toArray());
    }
}
