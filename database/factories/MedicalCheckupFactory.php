<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MedicalCheckup::class, function (Faker $faker) {
    return [
        'record_id' => function () {
            return factory(\App\Models\MedicalRecord::class)->create(['type' => 'App\Models\MedicalCheckup'])->id;
        },
        'title' => $faker->sentence,
        'report' =>  $faker->sentence(10),
        'checkup_date' => $faker->date('Y-m-d')
    ];
});
