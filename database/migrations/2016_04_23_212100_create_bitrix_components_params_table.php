<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_params', function (Blueprint $table){
			$table->increments('id');
			$table->integer('component_id')->unsigned();
			$table->foreign('component_id')->references('id')->on('bitrix_components')->onDelete('cascade');
			$table->integer('type_id')->unsigned();
			//$table->foreign('type_id')->references('id')->on('bitrix_components_params_types'); // todo
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name');
			$table->integer('group_id')->nullable();
			//$table->foreign('group_id')->references('id')->on('bitrix_components_params_groups'); // todo
			$table->boolean('refresh')->nullable();
			$table->boolean('multiple')->nullable();
			$table->string('values')->nullable();
			$table->boolean('additional_values')->nullable();
			$table->integer('size')->nullable();
			$table->string('default')->nullable();
			$table->integer('cols')->nullable();
			$table->string('spec_vals')->nullable();
			$table->string('spec_vals_args')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_params');
	}
}
