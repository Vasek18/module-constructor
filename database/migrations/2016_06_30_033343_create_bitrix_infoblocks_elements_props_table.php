<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixInfoblocksElementsPropsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_infoblocks_elements_props', function (Blueprint $table){
			$table->increments('id');
			$table->integer('prop_id')->unsigned();
			$table->foreign('prop_id')->references('id')->on('bitrix_infoblocks_props')->onDelete('cascade');
			$table->integer('element_id')->unsigned();
			$table->foreign('element_id')->references('id')->on('bitrix_infoblocks_elements')->onDelete('cascade');
			$table->string('value');
			$table->integer('sort')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_infoblocks_elements_props');
	}
}
