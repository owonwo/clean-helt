<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Patient::class, function (Faker $faker) {
    $gender = $faker->randomElements(['male', 'female']);
    $religion = $faker->randomElements(['Christianity', 'Muslim']);
    $marital_status = $faker->randomElements(['single', 'married', 'engaged', 'divorced']);

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->lastName,
        'avatar' => $faker->image(),
        'email' => $faker->unique()->safeEmail,
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'gender' => $gender,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'religion' => $religion,
        'marital_status' => $marital_status,

        'nok_name' => $faker->name,
        'nok_email' => $faker->unique()->safeEmail,
        'nok_phone' => $faker->phoneNumber,
        'nok_address' => $faker->address,
        'nok_city' => $faker->city,
        'nok_state' => $faker->city,
    ];
});
