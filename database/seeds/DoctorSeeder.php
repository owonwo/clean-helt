<?php

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Doctor::truncate();
            factory("App\Models\Doctor")->create(['email' => 'joebro@gmail.com']);
        }
    }
