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
			$table->string('code');
			$table->string('PARTNER_NAME');
			$table->string('PARTNER_URI');
			$table->string('PARTNER_CODE')->nullable();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('version')->default('0.0.1');
			$table->integer('download_counter')->nullable()->unsigned()->default(0); // наверное удалим
			$table->timestamp('last_download')->nullable();
			$table->string('default_lang')->default('ru');
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
