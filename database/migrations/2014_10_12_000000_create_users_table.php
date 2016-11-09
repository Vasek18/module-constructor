<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('users', function (Blueprint $table){
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('site')->nullable(); // сайт пользователя
			$table->string('company_name')->nullable(); // название его компании
			$table->string('bitrix_partner_code')->nullable()->unique(); // для модулей Битрикс
			$table->string('bitrix_company_name')->nullable(); // для модулей Битрикс // возможно не надо в виду company_name
			$table->integer('rubles')->unsigned()->default(0);
			$table->integer('paid_days')->unsigned()->default(0);
			$table->string('lang')->nullable();
			$table->integer('group_id')->unsigned()->nullable()->default(2);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('users');
	}
}
