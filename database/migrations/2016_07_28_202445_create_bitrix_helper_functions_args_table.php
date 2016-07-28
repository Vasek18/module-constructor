<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixHelperFunctionsArgsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_helper_functions_args', function (Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->integer('function_id')->unsigned();
			$table->foreign('function_id')->references('id')->on('bitrix_helper_functions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_helper_functions_args');
	}
}
