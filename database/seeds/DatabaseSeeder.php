<?php

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\ProfileShare;
use App\Models\DoctorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
<<<<<<< HEAD
        Schema::disableForeignKeyConstraints();
        $this->call(DoctorSeeder::class);
=======
        // $this->call(UsersTableSeeder::class);
        Schema::disableForeignKeyConstraints();
        $this->call(PatientSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(HospitalSeeder::class);
        $this->call(PharmacySeeder::class);
        $this->call(MedicalRecordSeeder::class);
>>>>>>> 362a66920447aa0d66e21527a2f6c974ea78e1f9
        Schema::enableForeignKeyConstraints();
    }
}
