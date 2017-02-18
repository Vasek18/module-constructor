<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBitrixInfoblockPropsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('bitrix_infoblocks_props', function (Blueprint $table){
			$table->text('dop_params')->nullable(); // на самом деле json
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('bitrix_infoblocks_props', function (Blueprint $table){
			$table->dropColumn('dop_params');
		});
	}
}
