<?php

// чисто для общих тестов

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

		factory(App\Models\User::class, 2)->create();

		Model::reguard();
	}
}
