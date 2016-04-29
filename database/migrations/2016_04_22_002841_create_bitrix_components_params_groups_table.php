<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsGroupsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_params_groups', function (Blueprint $table){
			$table->increments('id');
			$table->integer('component_id')->unsigned();
			//$table->foreign('component_id')->references('id')->on('bitrix_components');
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name')->nullable();
			$table->text('desc');
			$table->boolean('standard')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_params_groups');
	}
}
