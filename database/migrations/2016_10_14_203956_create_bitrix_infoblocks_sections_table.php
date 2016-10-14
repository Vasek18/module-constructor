<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixInfoblocksSectionsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_infoblocks_sections', function (Blueprint $table){
			$table->increments('id');
			$table->integer('iblock_id')->unsigned();
			$table->foreign('iblock_id')->references('id')->on('bitrix_infoblocks')->onDelete('cascade');
			$table->integer('parent_section_id')->unsigned()->nullable();
			$table->string('name');
			$table->string('code')->nullable();
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->boolean('active')->default(true);
			$table->string('picture_src')->nullable();
			$table->text('text')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_infoblocks_sections');
	}
}
