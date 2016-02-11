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
			$table->integer('module_id');
			$table->string('name');
			$table->string('code');
			$table->text('desc');
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
