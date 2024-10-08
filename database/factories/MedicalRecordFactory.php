<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MedicalRecord::class, function (Faker $faker) {
    return [
        'patient_id' => function() {
            return factory(\App\Models\Patient::class)->create()->id;
        },
        'type' => 'App\Models\Diagnosis',
        'issuer_type' => 'App\Models\Doctor',
        'issuer_id' =>function() {
            return factory(\App\Models\Doctor::class)->create()->id;
         }
    ];
});
