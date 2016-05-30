<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixMailEventsTemplatesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_mail_events_templates', function (Blueprint $table){
			$table->increments('id');
			$table->integer('mail_event_id')->unsigned();
			$table->foreign('mail_event_id')->references('id')->on('bitrix_mail_events')->onDelete('cascade');
			$table->string('name');
			$table->string('from');
			$table->string('to');
			$table->string('copy')->nullable();
			$table->string('hidden_copy')->nullable();
			$table->string('reply_to')->nullable();
			$table->string('in_reply_to')->nullable();
			$table->string('theme')->nullable();
			$table->text('body')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_mail_events_templates');
	}
}
