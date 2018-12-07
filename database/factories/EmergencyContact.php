<?php

use App\Models\EmergencyContact;
use Faker\Generator as Faker;

$factory->define(EmergencyContact::class, function (Faker $faker) {
    return [
        //
        'record_id' => function(){
            return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'name'  => $faker->name,
        'phone' => $faker->phoneNumber,
        'phone_2' => $faker->phoneNumber,
        'address' => $faker->address,
        'zip_code' => $faker->randomDigit
    ];
});
