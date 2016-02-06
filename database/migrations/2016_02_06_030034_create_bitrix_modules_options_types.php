<?php

// типы полей, которые мы можем использовать для настроек на странице настроек модуля

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixModulesOptionsTypes extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_modules_options_types', function (Blueprint $table){
			$table->increments('id');
			$table->string('NAME_RU');
			$table->string('NAME_EN');
			$table->string('FORM_TYPE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_modules_options_types');
	}
}
