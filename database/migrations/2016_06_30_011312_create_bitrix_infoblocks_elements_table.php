<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixInfoblocksElementsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_infoblocks_elements', function (Blueprint $table){
			$table->increments('id');
			$table->integer('iblock_id')->unsigned();
			$table->foreign('iblock_id')->references('id')->on('bitrix_infoblocks')->onDelete('cascade');
			$table->string('name');
			$table->string('code')->nullable();
			$table->integer('sort')->unsigned()->nullable();
			$table->boolean('active')->default(true);
			$table->string('preview_picture_src')->nullable();
			$table->text('preview_text')->nullable();
			$table->string('detail_picture_src')->nullable();
			$table->text('detail_text')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_infoblocks_elements');
	}
}
