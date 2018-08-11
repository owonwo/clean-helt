<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MedicalRecord::class, function (Faker $faker) {
    return [
        //
        'patient_id' => function(){
            factory('App\Models\Patient')->create()->id;
        },
        'type' => 1,
        'issuer_type' => 'App\Models\Doctor',
        'issuer_id' =>function(){
            factory('App\Models\Doctor')->create()->id;   
         },
        'comment' => $faker->sentence
    ];
});
