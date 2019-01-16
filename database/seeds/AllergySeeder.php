<?php

use Illuminate\Database\Seeder;

class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory("App\Models\Allergy", 20)->create();
    }
}
