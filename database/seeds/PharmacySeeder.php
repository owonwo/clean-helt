<?php

use App\Models\Pharmacy;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Pharmacy::truncate();
        factory("App\Models\Pharmacy")->create(['email' => 'jeramie.koelpin@example.com']);
        factory("App\Models\Pharmacy", 10)->create();
        Schema::enableForeignKeyConstraints();
    }
}
