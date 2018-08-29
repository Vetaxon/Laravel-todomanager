<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'user_id' => 5,
        'title' => $faker->text(70),
        'task' => $faker->text(200),
        'status' => $faker->randomElement(['on', 'done']),
        'urgency' => $faker->randomElement([1, 0]),
        'importance' => $faker->randomElement([1, 0]),
    ];
});
