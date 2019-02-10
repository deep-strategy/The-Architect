<?php

use App\Models\PriceFrequency;
use Faker\Generator as Faker;

$factory->define(PriceFrequency::class, function (Faker $faker) {
    return [
        'identifier' => 'time interval',
        'slug' => $faker->randomElement(['10min', 'daily'])
    ];
});
