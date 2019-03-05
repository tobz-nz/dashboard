<?php

use App\DeviceMetric;
use Faker\Generator as Faker;

$values = [
    2400,
    2386,
    2310,
    2270,
    2060,
    2010,
    1960,
    1920,
    1880,
    1860,
    1730,
    1630,
    1570,
    1510,
    1560,
    1530,
    1600,
    1660,
    1580,
    1530,
    1450,
    1420,
];

$factory->define(DeviceMetric::class, function (Faker $faker) use ($values) {
    return [
        'device_id' => 1,
        'type' => 'level',
        'value' => next($values),
    ];
});
