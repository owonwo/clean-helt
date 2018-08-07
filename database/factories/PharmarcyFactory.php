<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Pharmacy::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'chcode' => $faker->unique()->word,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'chief_pharmacist_reg' => $faker->word,
        'avatar' => 'avatar/avatar.jpeg'
    ];
});
