<?php

use App\Models\Pharmacy;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pharmacy::truncate();
        factory("App\Models\Pharmacy",10)->create();
    }
}
