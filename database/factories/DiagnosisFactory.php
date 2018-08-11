<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Diagnosis::class, function (Faker $faker) {
    return [
        //
        'record_id' => function(){
            return factory('App\Models\MedicalRecord')->create()->id;
        },
        'complaint_history' => $faker->sentence,
        'complaint_relationship' => $faker->word,
        'patient_condition' => 1,
        'symptoms' => $faker->word,
        'extras' => $faker->word,
    ];
});
