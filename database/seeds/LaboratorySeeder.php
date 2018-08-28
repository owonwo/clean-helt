<?php

use App\Models\Laboratory;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Laboratory::truncate();
        factory(\App\Models\Laboratory::class,10)->create();
    }   
}
