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
			$table->dropColumn('description')->nullable();
			$table->dropColumn('approved')->nullable()->default(false);
		});
	}
}
