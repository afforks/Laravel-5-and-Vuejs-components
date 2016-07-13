<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomNumber(4),
        'no_of_items' => $faker->randomNumber(2),
        'discount' => $faker->randomNumber(2),
        'total' => $faker->randomNumber(5)
    ];
});

$factory->define(App\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});