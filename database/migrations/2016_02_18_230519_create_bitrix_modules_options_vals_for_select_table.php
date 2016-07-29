<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixModulesOptionsValsForSelectTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_modules_options_vals_for_select', function (Blueprint $table){
			$table->increments('id');
			$table->integer('option_id')->unsigned();
			$table->foreign('option_id')->references('id')->on('bitrix_modules_options')->onDelete('cascade');
			$table->integer('sort');
			$table->string('key');
			$table->string('value');
			$table->boolean('is_default');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_modules_options_vals_for_select');
	}
}
