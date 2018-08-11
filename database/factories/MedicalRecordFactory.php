<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MedicalRecord::class, function (Faker $faker) {
    return [
        //
        'patient_id' => function(){
            factory('App\Models\Patient')->create()->id;
        },
        'type' => 1,
        'issuer_type' => $faker->colorName,
        'issuer_id' => 2,
    ];
});
