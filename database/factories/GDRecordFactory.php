<?php

use Faker\Generator as Faker;

$factory->define(App\Models\GDRecord::class, function (Faker $faker) {
    return [
        'record_id' => function () {
        		return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'age' => $faker->randomNumber,
        'weight' => $faker->randomNumber,
        'height' => $faker->randomNumber
    ];
});
