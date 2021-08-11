<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Veiculo;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

// Gerar dados falsos para popular o banco de dados
$factory->define(Veiculo::class, function (Faker $faker) {
    return [
       'marca' => $faker->name,
       'modelo' => $faker->name,
       'ano' => $faker->numberBetween($min = 1000, $max = 2021),  // 1000 ate 9000
       'preco' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL), // 48.8922
    ];
});




