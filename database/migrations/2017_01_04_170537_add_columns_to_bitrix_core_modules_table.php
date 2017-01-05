<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBitrixCoreModulesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('bitrix_core_modules', function (Blueprint $table){
			$table->boolean('approved')->nullable()->default(false);
			$table->integer('creator_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('bitrix_core_modules', function (Blueprint $table){
			$table->dropColumn('approved');
			$table->dropColumn('creator_id');
		});
	}
}
