<?php

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::truncate();
        factory(App\Models\Hospital::class)->create([
            'email' => 'admin@firstland.care', 
            'name' => 'First Land Hospital'
        ]);
        factory(App\Models\Hospital::class,10)->create();
    }
}
