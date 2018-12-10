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
        foreach (range(1, 5) as $number) {
            DB::table('doctor_hospital')->insert([
                'doctor_id' => $number,
                'hospital_id' => 1,
                'status' => '0',
                'actor' => "App\Models\Doctor",
            ]);
        }
    }
}
