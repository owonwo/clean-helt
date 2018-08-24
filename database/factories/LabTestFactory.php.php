<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LabTest::class, function (Faker $faker) {
    return [
        'record_id' => function () {
            return factory('App\Models\Patient')->create()->id;
        },


        'test_name' => $faker->name,
        'description' => $faker->paragraph(3),
        'result' => $faker->paragraph(3),
        'conclusion' => $faker->paragraph,
        'status' => true,


        'taker' => function () {
            return factory('App\Models\Laboratory')->create()->id;
        },


        'diagnosis_id' => function () {
        return factory('App\Models\Diagnosis')->create()->id;
        }
    ];
});
