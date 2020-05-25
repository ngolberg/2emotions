<?php

use App\Word;
use App\User;
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

$factory->define(Word::class, function (Faker $faker) {
  return [
    'user_id' => factory(User::class),
    'word' => $faker->unique()->word,
    'rate' => rand(0,1000),
    'type' => rand(0,1),
  ];
});
