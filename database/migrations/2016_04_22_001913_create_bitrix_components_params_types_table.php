<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsTypesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_params_types', function (Blueprint $table){
			$table->string('form_type')->unique(); // эт не тип формы, а скорее внутренний код в компонентах Битрикса
			$table->string('name_ru');
			$table->string('name_en');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_params_types');
	}
}
