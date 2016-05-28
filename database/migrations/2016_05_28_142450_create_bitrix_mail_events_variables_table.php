<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixMailEventsVariablesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_mail_events_variables', function (Blueprint $table){
			$table->increments('id');
			$table->integer('mail_event_id')->unsigned();
			$table->foreign('mail_event_id')->references('id')->on('bitrix_mail_events')->onDelete('cascade');
			$table->string('code');
			$table->string('name')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_mail_events_variables');
	}
}
