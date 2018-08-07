<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Hospital::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'chcode' => $faker->unique()->word,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'director_mdcn' => $faker->word,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'avatar' => 'avatar/avatar.jpeg'
    ];
});
