<?php

// таблица для хранения компонентов

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->string('name');
			$table->string('code');
			$table->string('uploaded_path');
			$table->integer('sort');
			$table->string('icon_path');
			$table->text('desc');
			$table->text('component_php'); // todo я не уверен, что здесь его место
			$table->string('steps')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components');
	}
}
