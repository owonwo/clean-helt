<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ShareExtension::class, function (Faker $faker) {
    
    $hospital = factory(App\Models\Hospital::class)->create();
    $doctor = factory(App\Models\Doctor::class)->create();
    $hospital->doctors()->attach($doctor, ['status' => 1]);
    
    $share = factory(App\Models\ProfileShare::class)->create([
        'provider_id' => $hospital->id,
        'provider_type' => get_class($hospital)
    ]);
    
    return [
        'share_id' => $share->id,
        'sharer_id' => $hospital->id,
        'sharer_type' => get_class($hospital),
        'provider_id' => $doctor->id,
        'provider_type' => get_class($doctor),
        'expired_at' => now()->addWeek(1)
    ];
});
