<?php

use Illuminate\Database\Seeder;

class HospitalContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\HospitalContacts', 20)->create();
    }
}
