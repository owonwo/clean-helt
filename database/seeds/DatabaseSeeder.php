<?php

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\ProfileShare;
use App\Models\DoctorProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call(DoctorSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
