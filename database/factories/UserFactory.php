<?php

use Faker\Generator as Faker;


$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Models\Doctor::class,function(Faker $faker){
    return [
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => $faker->password,
        'phone' => $faker->phoneNumber,
        'gender' =>$faker->lastName,
        'specialization' => 'cardiologist',
        'folio' => 'MB/12/20',
        'confirm' => false,
        'token' => str_random(10,16),
    ];
});
