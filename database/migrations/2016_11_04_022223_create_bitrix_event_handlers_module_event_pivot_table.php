<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixEventHandlersModuleEventPivotTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_event_handlers_module_event_pivot', function (Blueprint $table){
			$table->increments('id');
			$table->integer('handler_id')->unsigned();
			$table->foreign('handler_id')->references('id')->on('bitrix_events_handlers')->onDelete('cascade');
			$table->string('from_module');
			$table->string('event');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_event_handlers_module_event_pivot');
	}
}
