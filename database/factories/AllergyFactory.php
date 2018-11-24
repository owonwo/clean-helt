<?php

use App\Models\Allergy;
use Faker\Generator as Faker;

$factory->define(Allergy::class, function (Faker $faker) {
    return [
        //
        'record_id' => function () {
            return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'allergy' => $faker->sentence(6),
        'reaction' =>  $faker->sentence(6),
        'last_occurance' => $faker->date('Y-m-d')
    ];
});
