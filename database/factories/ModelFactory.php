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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'site' => $faker->url,
        'company_name' => $faker->company,
        'bitrix_partner_code' => $faker->word,
        'bitrix_company_name' => $faker->company,
        'password' => bcrypt("12345678"),
        'remember_token' => str_random(10),
    ];
});
