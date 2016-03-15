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

$factory->define(App\Models\User::class, function (Faker\Generator $faker){
	return [
		'first_name'          => $faker->name,
		'last_name'           => $faker->lastName,
		'email'               => $faker->email,
		'site'                => $faker->url,
		'company_name'        => $faker->company,
		'bitrix_partner_code' => $faker->word,
		'bitrix_company_name' => $faker->company,
		'password'            => bcrypt("12345678"),
		'remember_token'      => str_random(10),
	];
});

$factory->define(App\Models\Modules\Bitrix\Bitrix::class, function (Faker\Generator $faker){
	$user = factory(App\Models\User::class)->create();

	return [
		'MODULE_NAME'        => $faker->word,
		'MODULE_CODE'        => $faker->word,
		'MODULE_DESCRIPTION' => $faker->sentence(7),
		'PARTNER_NAME'       => $user->first_name,
		'PARTNER_URI'        => $user->site,
		'PARTNER_CODE'       => $user->bitrix_partner_code,
		'user_id'            => $user->id,
		'VERSION'            => "0.0.1",
		'download_counter'   => 0,
	];
});
