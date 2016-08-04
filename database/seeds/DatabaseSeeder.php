<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();

		// я todo del
		DB::table('users')->insert([
			'first_name'     => 'Вася',
			'last_name'      => 'Аристов',
			'email'          => 'aristov-92@mail.ru',
			'password'       => bcrypt("12345678"),
			'remember_token' => str_random(10),
			'rubles'         => 1487,
			'payed_days'     => 1487,
			'group_id'       => 1,
		]);

		// группы пользователей
		DB::table('user_groups')->insert([
			'code' => 'admin',
			'name' => 'Админы',
		]);
		DB::table('user_groups')->insert([
			'code' => 'holops',
			'name' => 'Простые пользователи',
		]);

		$this->call(BitrixStuffSeeder::class);

		Model::reguard();
	}
}
