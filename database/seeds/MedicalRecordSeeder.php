<?php

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // MedicalRecord::truncate();

        $type = ['App\Models\Prescription'];

        $patient = Patient::take(10)->get()->pluck('id');

        $patient->each(function ($item, $key) use ($type) {
            $rand_keys = array_rand($type);

            $medical_record = factory('App\Models\MedicalRecord')
            ->create(['patient_id' => $item, 'type' => $type[$rand_keys]]);
            switch ($type[$rand_keys]) {
                case "App\Models\Diagnosis":
                     $diagnosis = factory("App\Models\Diagnosis")->create(['record_id' => $medical_record->id]);

                     return $diagnosis;
                case "App\Models\LabTest":
                    $labtest = factory("App\Models\LabTest")->create(['record_id' => $medical_record->id]);

                    return $labtest;
                case "App\Models\Prescription":
                    $prescription = factory("App\Models\Prescription")->create(['record_id' => $medical_record->id]);

                    return $prescription;
            }
        });
    }
}
