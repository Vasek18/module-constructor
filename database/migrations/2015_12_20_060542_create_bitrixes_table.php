<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixesTable extends Migration{
	/**
	 * Таблица для модулей Битрикса
	 *
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrixes', function (Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('partner_name');
			$table->string('partner_uri');
			$table->string('partner_code')->nullable();
			$table->integer('user_id');
			$table->timestamp('published_at')->nullable(); // мб лишнее
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrixes');
	}
}
