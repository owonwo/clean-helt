<?php
use App\Models\HealthInsurance;
use Faker\Generator as Faker;

$factory->define(HealthInsurance::class, function (Faker $faker) {
    return [
       		 'record_id' => function () {
            		return factory(\App\Models\MedicalRecord::class)->create()->id;
        		},
             'insurance_type' => $faker->name,
             'company_name' => $faker->company,
             'address' => $faker->address,
             'city' => $faker->city,
             'phone' => $faker->phoneNumber,
             'emergency_phone' => $faker->phoneNumber
    ];
});
