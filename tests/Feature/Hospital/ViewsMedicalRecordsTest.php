<?php

namespace Tests\Feature\Hospital;

use App\Models\Diagnosis;
use App\Models\Hospital;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewsMedicalRecordsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_hospital_can_view_shared_patients_medical_records()
    {
        $hospital = create(Hospital::class);

        $patient = create(Patient::class);

        $records = create(MedicalRecord::class, ['patient_id' => $patient->id], 2);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/patients/{$patient->chcode}/records")
            ->assertSee($records->first()->reference)
            ->assertSee($records->last()->reference);
    }

    /** @test */
    public function a_hospital_can_filter_shared_patients_medical_records_by_type()
    {
        $hospital = create(Hospital::class);

        $patient = create(Patient::class);

        $diagnosisRecords = create(MedicalRecord::class, ['patient_id' => $patient->id], 2);
        $prescriptionRecords = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\Prescription'
        ], 2);
        $labRecords = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\LabTest'
        ], 2);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/patients/{$patient->chcode}/records?type=diagnosis")
            ->assertSee($diagnosisRecords->first()->reference)
            ->assertSee($diagnosisRecords->last()->reference)
            ->assertDontSee($prescriptionRecords->first()->reference)
            ->assertDontSee($prescriptionRecords->last()->reference)
            ->assertDontSee($labRecords->first()->reference)
            ->assertDontSee($labRecords->last()->reference);

    }

    /** @test */
    public function a_hospital_can_filter_shared_patients_medical_records_by_start_date()
    {
        $hospital = create(Hospital::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $startDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/patients/{$patient->chcode}/records?start_date={$startDate}")
            ->assertSee($recordTwo->reference)
            ->assertDontSee($recordOne->reference);
    }

    /** @test */
    public function a_hospital_can_filter_shared_patients_medical_records_by_end_date()
    {
        $hospital = create(Hospital::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $endDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/patients/{$patient->chcode}/records?end_date={$endDate}")
            ->assertDontSee($recordTwo->reference)
            ->assertSee($recordOne->reference);
    }

    /** @test */
    public function a_hospital_can_view_shared_patients_single_medical_record()
    {
        $hospital = create(Hospital::class);

        $patient = create(Patient::class);

        $record = create(MedicalRecord::class, ['patient_id' => $patient->id]);

        $diagnosis = create(Diagnosis::class, ['record_id' => $record->id]);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $hospital->id,
            'provider_type' => get_class($hospital)
        ]);

        $this->signIn($hospital, 'hospital');

        $this->makeAuthRequest()
            ->get("api/hospital/patients/{$patient->chcode}/records/{$record->reference}")
            ->assertSee($diagnosis->complaint_history);
    }
}
