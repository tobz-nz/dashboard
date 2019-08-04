<?php

use App\DeviceMetric;
use Faker\Generator as Faker;

$factory->define(DeviceMetric::class, function (Faker $faker) {
    return [
        'device_id' => 1,
        'type' => 'level',
        'value' => $faker->numberBetween(0, 2500),
        'created_at' => $faker->dateTimeThisMonth(),
    ];
});
