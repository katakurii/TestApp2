<?php

use Faker\Generator as Faker;

$factory->define(App\Member::class, function (Faker $faker) {
	$photo = null;
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'age' => $faker->randomNumber(2),
        'photo' => $photo,
    ];
});
