<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixEventsHandlersTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_events_handlers', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id');
			$table->string('event');
			$table->string('class');
			$table->string('method');
			$table->longText('php_code')->nullable();
			$table->timestamps();
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
