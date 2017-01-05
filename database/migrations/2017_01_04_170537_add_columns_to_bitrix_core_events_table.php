<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBitrixCoreEventsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('bitrix_core_events', function (Blueprint $table){
			$table->string('params')->nullable();
			$table->text('description')->nullable();
			$table->boolean('approved')->nullable()->default(false);
			$table->boolean('is_bad')->nullable()->default(false);
			$table->integer('creator_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('bitrix_core_events', function (Blueprint $table){
			$table->dropColumn('params');
			$table->dropColumn('description');
			$table->dropColumn('approved');
			$table->dropColumn('is_bad');
			$table->dropColumn('creator_id');
		});
	}
}
