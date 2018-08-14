<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProfileShare::class, function (Faker $faker) {
    return [
        'patient_id' => function() {
            return factory(App\Models\Patient::class)->create()->id;
        },
        'provider_type' => 'App\Models\Doctor',
        'provider_id' => function() {
            return factory(App\Models\Doctor::class)->create()->id;
        },
        'expired_at' => Carbon\Carbon::tomorrow(),
        'created_at' => \Carbon\Carbon::now()
    ];
});
