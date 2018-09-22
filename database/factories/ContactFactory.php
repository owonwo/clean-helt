<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Contact::class, function (Faker $faker) {
    return [
        'owner_id' => function() {
            return factory(\App\Models\Patient::class)->create()->id;
        },
        'owner_type' => 'App\\Models\\Patient',
        'contact_id' => function() {
            return factory(\App\Models\Doctor::class)->create()->id;
        },
        'contact_type' => 'App\\Models\\Doctor'
    ];
});
