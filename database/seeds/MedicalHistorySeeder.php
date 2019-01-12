<?php

use Illuminate\Database\Seeder;

use App\Models\MedicalHistory;

class MedicalHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalHistory::truncate();
        
        $patients = factory("App\Models\Patient", 10)->create();

        $patients->each(function($patient) {
            $record = factory("App\Models\MedicalRecord")
                        ->create([
                            'patient_id' => $patient->id,
                            'type' => "App\\Models\\MedicalHistory"
                        ]);
            factory("App\Models\MedicalHistory")->create(['record_id' => $record->id]);
        });
    
    }
}
