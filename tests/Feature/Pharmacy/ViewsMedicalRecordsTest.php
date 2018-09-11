<?php

namespace Tests\Feature\Pharmacy;

use App\Models\Diagnosis;
use App\Models\Hospital;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\Prescription;
use App\Models\ProfileShare;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ViewsMedicalRecordsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_pharmacy_can_view_only_her_patients_prescriptions()
    {
        $patient = create(Patient::class);

        $pharmacy = create(Pharmacy::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => '1'
        ]);

        $diagnosisRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\Diagnosis'
        ]);

        $prescriptionRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\Prescription'
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get("api/pharmacy/patients/{$patient->chcode}/records")
            ->assertSee($prescriptionRecord->reference)
            ->assertDontSee($diagnosisRecord->reference);
    }


    /** @test */
    public function a_pharmacy_can_filter_shared_patients_medical_records_by_start_date()
    {
        $pharmacy = create(Pharmacy::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'type' => 'App\Models\Prescription',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'type' => 'App\Models\Prescription',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $startDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => '1'
        ]);

        $this->signIn($pharmacy, 'pharmacy');
        $this->makeAuthRequest()
            ->get("api/pharmacy/patients/{$patient->chcode}/records?start_date={$startDate}")
            ->assertSee($recordTwo->reference)
            ->assertDontSee($recordOne->reference);
    }

    /** @test */
    public function a_pharmacy_can_filter_shared_patients_medical_records_by_end_date()
    {
        $pharmacy = create(Pharmacy::class);

        $patient = create(Patient::class);

        $recordOne = create(MedicalRecord::class, [
            'type' => 'App\Models\Prescription',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);

        $recordTwo = create(MedicalRecord::class, [
            'type' => 'App\Models\Prescription',
            'patient_id' => $patient->id,
            'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s')
        ]);

        $endDate = Carbon::now()->subDays(4)->format('Y-m-d');

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => '1'
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get("api/pharmacy/patients/{$patient->chcode}/records?end_date={$endDate}")
            ->assertDontSee($recordTwo->reference)
            ->assertSee($recordOne->reference);
    }

    /** @test */
    public function a_pharmacy_can_view_shared_patients_single_medical_record()
    {
        $pharmacy = create(Pharmacy::class);

        $patient = create(Patient::class);

        $record = create(MedicalRecord::class, [
            'type' => 'App\Models\Prescription',
            'patient_id' => $patient->id
        ]);

        $prescription = create(Prescription::class, ['record_id' => $record->id]);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => '1'
        ]);

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->get("api/pharmacy/patients/{$patient->chcode}/records/{$record->reference}")
            ->assertSee($prescription->name);
    }

    /** @test */
    public function a_pharmacy_can_dispense_prescriptions()
    {
        $patient = create(Patient::class);

        $pharmacy = create(Pharmacy::class);

        create(ProfileShare::class, [
            'patient_id' => $patient->id,
            'provider_id' => $pharmacy->id,
            'provider_type' => get_class($pharmacy),
            'status' => "1"
        ]);

        $prescriptionRecord = create(MedicalRecord::class, [
            'patient_id' => $patient->id,
            'type' => 'App\Models\Prescription'
        ]);

        $prescriptionOne = create(Prescription::class, [
            'record_id' => $prescriptionRecord->id
        ]);

        $update = [
            "comment" => "Drug has been dispensed"
        ];

        $this->signIn($pharmacy, 'pharmacy');

        $this->makeAuthRequest()
            ->patch("api/pharmacy/patients/{$patient->chcode}/records/{$prescriptionRecord->reference}/{$prescriptionOne->id}", $update);

        $this->assertDatabaseHas('prescriptions', [
            'record_id' => $prescriptionRecord->id,
            'id' => $prescriptionOne->id,
            'status' => true,
            'comment' => $update["comment"]
        ]);
    }
}
