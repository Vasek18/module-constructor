<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixArbitraryFilesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_arbitrary_files', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->string('filename');
			$table->string('path');
			$table->string('location')->default('in_module');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_arbitrary_files');
	}
}
