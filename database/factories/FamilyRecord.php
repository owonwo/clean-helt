<?php

use App\Models\FamilyRecord;
use Faker\Generator as Faker;

$diseases = [
    "Sickle cell disease",
    "Genetic disorder",
    "Birth defect",
    "Cystic fibrosis",
    "Chromosome abnormality",
    "Huntington's disease",
    "Down syndrome",
    "Tay–Sachs disease",
    "Muscular dystrophy",
    "Haemophilia",
    "Deletion",
    "Hearing loss",
    "Phenylketonuria",
    "Gaucher's disease",
    "Fragile X syndrome",
    "Ataxia"
];

$factory->define(FamilyRecord::class, function (Faker $faker) use ($diseases) {
    return [
        'record_id' => function () {
            return factory(\App\Models\MedicalRecord::class)->create([
                'type' => "App\\Models\\FamilyRecord"    
            ])->id;
        },
        'disease' => $faker->randomElement($diseases),
        'carriers' => json_encode(['mother', 'father', 'husband']),
        'description' => $faker->sentence,
        'created_at' => $faker->date("now"),
    ];
});
