<?php

use Illuminate\Database\Seeder;

class DoctorHospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('doctor_hospital')->insert([
            "doctor_id" => 1,
            "hospital_id" => factory("App\Models\Hospital")->create()->id,
            "status" => 1,
            "actor" => "App\Models\Hospital",
        ]);
    }
}
