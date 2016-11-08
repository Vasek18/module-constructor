<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('settings', function (Blueprint $table){
			$table->increments('id');
			$table->integer('group_id')->unsigned()->nullable();
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name');
			$table->string('value')->nullable();
			$table->timestamps();
		});

		DB::table('settings')->insert([
			'code'  => 'demo_days',
			'name'  => 'Длительность демопериода в днях',
			'value' => '2',
		]);

		DB::table('settings')->insert([
			'code'  => 'day_price',
			'name'  => 'Цена за день',
			'value' => '100',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('settings');
	}
}
