<?php

use App\Models\HospitalContacts;
use Faker\Generator as Faker;

$factory->define(HospitalContacts::class, function (Faker $faker) {
    return [
        //
        'record_id' =>  function () {
            return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'location' => $faker->address
    ];
});
