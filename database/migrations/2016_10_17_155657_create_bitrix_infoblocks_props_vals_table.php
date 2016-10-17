<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixInfoblocksPropsValsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_infoblocks_props_vals', function (Blueprint $table){
			$table->increments('id');
			$table->integer('prop_id')->unsigned();
			$table->foreign('prop_id')->references('id')->on('bitrix_infoblocks_props')->onDelete('cascade');
			$table->string('value');
			$table->integer('sort')->unsigned()->default(500);
			$table->boolean('default')->nullable()->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_infoblocks_props_vals');
	}
}
