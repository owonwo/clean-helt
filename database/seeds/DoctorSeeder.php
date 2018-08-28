<?php

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
        factory(DoctorProfile::class)->create();
    }

    }
