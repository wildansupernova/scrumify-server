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

$factory->define(App\Tasks::class, function (Faker $faker) {
    return [
        'group_id' => App\Groups::pluck('id')->random(),
        'task_name' => $faker->sentence($nbWords = 3),
        'description' => array_random([$faker->text($maxNbChars = 50), ""]),
        'kanban_status' => $faker->randomElement(Config::get('constants.KANBAN_STATUS')),
        'work_hour' => $faker->numberBetween($min = 1, $max = 100),
    ];
});