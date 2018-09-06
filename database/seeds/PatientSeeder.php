<?php

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Patient::truncate();
        factory("App\Models\Patient")->create([
            'email' => 'rocio.daniel@example.com',
        ]);
        factory("App\Models\Patient", 10)->create();
        Schema::enableForeignKeyConstraints();
    }
}
