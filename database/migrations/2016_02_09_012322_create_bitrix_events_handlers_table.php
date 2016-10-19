<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// todo можно нормализовать разделив на таблицы модуль-событие и класс обработчик (много к одному)
class CreateBitrixEventsHandlersTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_events_handlers', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->string('from_module');
			$table->string('event');
			$table->string('class');
			$table->string('method');
			$table->string('params')->nullable();
			$table->longText('php_code')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_events_handlers');
	}
}
