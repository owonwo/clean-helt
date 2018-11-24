<?php

use App\Models\Immunization;
use Faker\Generator as Faker;

$factory->define(Immunization::class, function (Faker $faker) {
    return [
        'record_id' => function () {
        return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'immunization_title' => $faker->sentence(6),
        'age' => $faker->numberBetween(1,30),
        'date_of_immunization' => $faker->date('Y-m-d')
    ];
});
