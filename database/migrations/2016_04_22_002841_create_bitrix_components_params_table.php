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
			$table->foreign('type_id')->references('id')->on('bitrix_components_params_types');
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name');
			$table->integer('parent'); // решил не указывать это как внешний ключ, хотя он им и является
			$table->string('refresh')->nullable();
			$table->string('multiple')->nullable();
			$table->string('values')->nullable();
			$table->string('additional_values')->nullable();
			$table->integer('size')->nullable();
			$table->string('default')->nullable();
			$table->integer('cols')->nullable();
			$table->timestamps();
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
