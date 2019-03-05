<?php

use App\DeviceUid;
use Faker\Generator as Faker;

$factory->define(DeviceUid::class, function (Faker $faker) {
    return [
        'uid' => strtolower(str_replace(':', '', $faker->macAddress)),
    ];
});
