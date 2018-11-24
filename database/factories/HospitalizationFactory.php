<?php

use App\Models\Hospitalize;
use Faker\Generator as Faker;

$factory->define(Hospitalize::class, function (Faker $faker) {
    return [
        //
       'record_id' => function(){
       		return factory(\App\Models\MedicalRecord::class)->create()->id;
       },
       'hospitalization_type' => $faker->name,
       'hospital' => $faker->company,
       'doctor' => 'Dr.' . $faker->name,
       'reason' => $faker->sentence,
       'complications' => $faker->sentence
    ];
});
