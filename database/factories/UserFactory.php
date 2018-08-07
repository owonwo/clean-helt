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
        'folio' => 'MB/12/'.str_random(2),
        'chcode' => $faker->unique()->word,
        'confirm' => false,
        'token' => str_random(40),
    ];
});
$factory->define(App\Models\DoctorProfile::class,function(Faker $faker){

    return [
        'doctors_id' => function(){
            return factory('App\Models\Doctor')->create()->id;
        },
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'mode_of_contact' => $faker->boolean,
        'marital_status' => 'Single',
        'religion' => 'Christianity',
        'kin_fullname' => $faker->name,
        'kin_address' => $faker->address,
        'kin_phone' => $faker->phoneNumber,
        'kin_city' => $faker->city,
        'kin_state' => $faker->city,
        'kin_country' => $faker->country,
        'name_of_degree' => 'Doctrate Degree',
        'institution' => 'Rivers State university',
        'additional_degree' =>  'Bachelor of Science',
        'years_in_practice' => 4,
        'active' => true,
        'avatar' => 'avatar/avatar.jpg',
        'disability' => $faker->text,
    ];
});
