<?php

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Doctor::truncate();
        DoctorProfile::truncate();

        $doctor = factory(Doctor::class)->create([
            'email' => 'dessie.conrey@gmail.com',
        ]);
        factory(DoctorProfile::class)->create(['doctors_id' => $doctor->id]);

        factory(DoctorProfile::class, 10)->create();
    }
}
