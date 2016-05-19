<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsArbitraryFilesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_arbitrary_files', function (Blueprint $table){
			$table->increments('id');
			$table->integer('component_id')->unsigned();
			$table->foreign('component_id')->references('id')->on('bitrix_components')->onDelete('cascade');
			$table->string('filename');
			$table->string('path');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_arbitrary_files');
	}
}
