<?php

use App\Device;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'uid' => 'unique-id',
        'api_token' => 'api-token',
        'owner_id' => 1,
        'name' => $faker->words(3, true),
        'color' => $faker->hexcolor,
        'address' => [
            'name' => $faker->streetAddress,
            'city' => $faker->city,
            'country' => $faker->country,
            'latlng' => [
                'lat' => $faker->latitude,
                'lng' => $faker->longitude,
            ],
        ],
        'household_size' => $faker->numberBetween(1, 6),
        'dimensions' => [
            'shape' => 'cylinder',
            'height' => ceil($faker->numberBetween(1000, 2500) / 10) * 10,
            'diameter' => ceil($faker->numberBetween(100, 400) / 10) * 10, // nearist 10
        ],
    ];
});
