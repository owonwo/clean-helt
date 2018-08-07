<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Laboratory::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'licence_no' => str_random(15),
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->password(),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'lab_owner' => $faker->name,
        'cac_reg' => str_random(15),
        'fmoh_reg' => str_random(15),
        'offers' => $faker->paragraph('3'),
    ];
});
