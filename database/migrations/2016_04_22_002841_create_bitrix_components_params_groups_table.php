<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsGroupsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_params_groups', function (Blueprint $table){
			$table->increments('id');
			$table->integer('component_id')->unsigned();
			//$table->foreign('component_id')->references('id')->on('bitrix_components');
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name')->nullable();
			$table->text('desc');
			$table->boolean('standard')->default(false);
		});

		// здесь потому что можно добавлять свои
		// стандартные группы опций для arParams компоненты
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'BASE',
			'sort'     => 100,
			'name'     => 'Основные параметры',
			'desc'     => 'Основные параметры.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'DATA_SOURCE',
			'sort'     => 200,
			'name'     => 'Источник данных',
			'desc'     => 'Тип и ID инфоблока.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'VISUAL',
			'sort'     => 300,
			'name'     => 'Внешний вид',
			'desc'     => 'Редко используемая группа. Сюда предполагается загонять параметры, отвечающие за внешний вид.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'URL_TEMPLATES',
			'sort'     => 400,
			'name'     => 'Шаблоны ссылок',
			'desc'     => 'Шаблоны ссылок',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'SEF_MODE',
			'sort'     => 500,
			'desc'     => 'Группа для всех параметров, связанных с использованием ЧПУ.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'AJAX_SETTINGS',
			'sort'     => 550,
			'desc'     => 'Все, что касается ajax.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'CACHE_SETTINGS',
			'sort'     => 600,
			'name'     => 'Настройки кеширования',
			'desc'     => 'Появляется при указании параметра CACHE_TIME.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code'     => 'ADDITIONAL_SETTINGS',
			'sort'     => 700,
			'name'     => 'Дополнительные настройки',
			'desc'     => 'Эта группа появляется, например, при указании параметра SET_TITLE.',
			'standard' => true
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_params_groups');
	}
}
