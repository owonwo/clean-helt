<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Prescription::class, function (Faker $faker) {
    return [
        //
        'record_id' => function(){
            return factory('App\Models\MedicalRecord')->create()->id;
        },
        'quantity' => $faker->randomDigitNotNull,
        'frequency' => $faker->randomDigitNotNull,
        'name' => $faker->colorName,
        'pharmacy_id' => function(){
            return factory('App\Models\Pharmacy')->create()->id;
        },
        'diagnosis_id' => function(){
            return factory('App\Models\Diagnosis')->create()->id;
        },
        'comment' => $faker->sentence,
        'status' => $faker->boolean
    ];
});
