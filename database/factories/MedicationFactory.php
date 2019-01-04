<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Medication::class, function (Faker $faker) {
    return [
        'record_id' => function () {
        	return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
         
        'name' => $faker->word,
        'dosage' => $faker->sentence,
        'frequency' => 3,
        'date' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
