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
		});
	}
}
