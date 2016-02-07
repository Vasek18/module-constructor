<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixModulesOptionsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_modules_options', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id');
			$table->integer('type_id');
			$table->string('code');
			$table->string('name');
			$table->integer('height')->nullable();
			$table->integer('width')->nullable();
			$table->integer('vals')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_modules_options');
	}
}
