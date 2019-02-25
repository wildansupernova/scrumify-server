<?php

use Illuminate\Support\Str;
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

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => App\User::pluck('id')->random(),
        'comment' => $faker->text($maxNbChars = 50),
        'task_id' => App\Tasks::pluck('id')->random()
    ];
});