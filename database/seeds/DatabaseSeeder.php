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
			'money'          => 1487
		]);

		$this->call(BitrixStuffSeeder::class);

		Model::reguard();
	}
}
