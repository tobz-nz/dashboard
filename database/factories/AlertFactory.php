<?php

use Faker\Generator as Faker;

$factory->define(App\Alert::class, function (Faker $faker) {
    return [
        'trigger' => $faker->numberBetween(1, 3),
        'percent' => $faker->numberBetween(0, 100),
    ];
});
