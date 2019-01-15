<?php

use Illuminate\Database\Seeder;

class FamilyRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory("App\Models\FamilyRecord", 20)->create();
    }
}
