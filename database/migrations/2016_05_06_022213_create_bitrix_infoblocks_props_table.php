<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixInfoblocksPropsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_infoblocks_props', function (Blueprint $table){
			$table->increments('id');
			$table->integer('iblock_id')->unsigned();
			$table->foreign('iblock_id')->references('id')->on('bitrix_infoblocks')->onDelete('cascade');
			$table->integer('sort')->unsigned();
			$table->string('code');
			$table->string('name');
			$table->string('type');
			$table->boolean('multiple');
			$table->boolean('is_required');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_infoblocks_props');
	}
}
