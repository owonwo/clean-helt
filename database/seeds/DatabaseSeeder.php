<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Schema::disableForeignKeyConstraints();
        $this->call(PatientSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(HospitalSeeder::class);
        $this->call(PharmacySeeder::class);
        $this->call(LaboratorySeeder::class);
        // $this->call(ContactSeeder::class);
        // $this->call(MedicalRecordSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
