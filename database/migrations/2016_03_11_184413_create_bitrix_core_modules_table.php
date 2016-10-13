<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixCoreModulesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_core_modules', function (Blueprint $table){
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('code');
		});

		// здесь потому что можно добавлять свои
		DB::table('bitrix_core_modules')->insert([
			'code' => 'main',
			'name' => 'Главный',
		]);

		DB::table('bitrix_core_modules')->insert([
			'code' => 'iblock',
			'name' => 'Инфоблоки',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_core_modules');
	}
}
