<?php

namespace Tests\Feature\Laboratory;

use App\Models\Laboratory;
use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\ProfileShare;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ViewsMedicalRecordsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorize_laboratory_can_view_patient_medical_record()
    {
        $patient = create(Patient::class);

        $laboratory = create(Laboratory::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory)
        ]);

        $diagnosisRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\Diagnosis'
        ]);

        $testRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\LabTest'
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->get("api/laboratories/patient/{$patient->chcode}/records")
            ->assertSee($testRecord->reference)
            ->assertDontSee($diagnosisRecord->reference);
    }


    /** @test */
    public function a_laboratory_can_filter_shared_patients_medical_records_by_start_date()
    {
        $laboratory = create(Laboratory::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'type' => 'App\Models\LabTest',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'type' => 'App\Models\LabTest',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $startDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory)
        ]);

        $this->signIn($laboratory, 'laboratory');
        $this->makeAuthRequest()
            ->get("api/laboratories/patient/{$patient->chcode}/records?start_date={$startDate}")
            ->assertSee($recordTwo->reference)
            ->assertDontSee($recordOne->reference);
    }

    /** @test */
    public function a_laboratory_can_filter_shared_patients_medical_records_by_end_date()
    {
        $laboratory = create(Laboratory::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'type' => 'App\Models\LabTest',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'type' => 'App\Models\LabTest',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $endDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory)
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->get("api/laboratories/patient/{$patient->chcode}/records?end_date={$endDate}")
            ->assertDontSee($recordTwo->reference)
            ->assertSee($recordOne->reference);
    }

    /** @test */
    public function a_laboratory_can_view_shared_patients_single_medical_record()
    {
        $laboratory = create(Laboratory::class);

        $patient = create(Patient::class);

        $record = create(MedicalRecord::class, [
            'type' => 'App\Models\LabTest',
            'patient_id' => $patient->id
        ]);

        $prescription = create(LabTest::class, ['record_id' => $record->id]);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory)
        ]);

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->get("api/laboratories/patient/{$patient->chcode}/records/{$record->reference}")
            ->assertSee($prescription->name);
    }

    /** @test */
    public function a_laboratory_can_update_add_Labtest_to_medical_record()
    {
        $patient = create(Patient::class);

        $laboratory = create(Laboratory::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $laboratory->id,
            'provider_type' => get_class($laboratory)
        ]);

        $labtestRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\LabTest'
        ]);

        $labtestOne = create(LabTest::class, [
            'record_id' => $labtestRecord->id
        ]);

        $update = [
            'result' => 'gdgg',
        ];

        $this->signIn($laboratory, 'laboratory');

        $this->makeAuthRequest()
            ->post("api/laboratories/patient/{$patient->chcode}/records/{$labtestRecord->reference}/{$labtestOne->id}", $update);

        $this->assertDatabaseHas('lab_tests', [
            'record_id' => $labtestRecord->id,
            'id' => $labtestOne->id,
            'status' => true,
            'result' => $update['result']
        ]);
    }
}
