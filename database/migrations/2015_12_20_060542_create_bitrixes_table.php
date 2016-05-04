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
			$table->string('MODULE_NAME'); // todo избавиться от "MODULE_"
			$table->text('MODULE_DESCRIPTION')->nullable(); // todo избавиться от "MODULE_"
			$table->string('MODULE_CODE'); // todo избавиться от "MODULE_"
			$table->string('PARTNER_NAME');
			$table->string('PARTNER_URI');
			$table->string('PARTNER_CODE')->nullable();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('VERSION')->default('0.0.1');
			$table->integer('download_counter')->nullable()->unsigned()->default(0);
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
