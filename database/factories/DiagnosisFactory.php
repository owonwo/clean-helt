<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Diagnosis::class, function (Faker $faker) {
    return [
        'record_id' => function () {
            return factory(\App\Models\MedicalRecord::class)->create()->id;
        },
        'complaint_history' => $faker->paragraph,
        'complaint_relationship' => $faker->sentence,
        'patient_condition' => $faker->randomElement([1, 2, 3]),
        'symptoms' => json_encode([$faker->word, $faker->word, $faker->word]),
        'extras' => json_encode([$faker->word => $faker->word, $faker->word => $faker->word]),
        'comments' => $faker->sentence,
    ];
});
