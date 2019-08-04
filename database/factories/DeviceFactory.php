<?php

use App\Device;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'uid' => Str::random(18),
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
            'height' => 2500,
            'diameter' => ceil($faker->numberBetween(100, 400) / 10) * 10, // nearist 10
        ],
    ];
});
