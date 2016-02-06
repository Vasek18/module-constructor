<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBitrixOptionsCodeField extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::table('bitrix_modules_options', function (Blueprint $table){
			$table->string('code')->after('type_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::table('bitrix_modules_options', function (Blueprint $table){
			$table->dropColumn('code');
		});
	}
}
