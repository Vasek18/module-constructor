<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsValsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_params_vals', function (Blueprint $table){
			$table->increments('id');
			$table->integer('param_id')->unsigned();
			$table->foreign('param_id')->references('id')->on('bitrix_components_params')->onDelete('cascade');
			$table->integer('sort');
			$table->string('key');
			$table->string('value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_params_vals');
	}
}
