<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AppStuff extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();
		Model::reguard();
	}
}
