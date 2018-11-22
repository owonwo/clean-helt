<?php

use Faker\Generator as Faker;
use App\Models\MedicalHistory;
$factory->define(MedicalHistory::class, function (Faker $faker) {
    return [
        //
        'record_id' => function () {
        		return factory(\App\Models\MedicalRecord::class)->create()->id;
         },
        'illness' => $faker->name,
        'date_of_onset' => $faker->date
    ];
});
