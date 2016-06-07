<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BitrixStuffSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();

		// типы опций для страницы настройки модулей
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Строка',
			'FORM_TYPE' => 'text',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Многострочный текст',
			'FORM_TYPE' => 'textarea',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Селект',
			'FORM_TYPE' => 'selectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Множественный селект',
			'FORM_TYPE' => 'multiselectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Чекбокс',
			'FORM_TYPE' => 'checkbox',
		]);

		// модули ядра (используется как минимум для подстановки при создании обработчиков событий)
		DB::table('bitrix_core_modules')->insert([
			'code' => 'main',
			'name' => 'Главный',
		]);

		DB::table('bitrix_core_modules')->insert([
			'code' => 'iblock',
			'name' => 'Инфоблоки',
		]);

		// типы опций для arParams компоненты
		DB::table('bitrix_components_params_types')->insert([
			'NAME_RU'   => 'Строка',
			'NAME_EN'   => 'String',
			'FORM_TYPE' => 'STRING',
		]);
		DB::table('bitrix_components_params_types')->insert([
			'NAME_RU'   => 'Селект',
			'NAME_EN'   => 'Select',
			'FORM_TYPE' => 'LIST',
		]);
		DB::table('bitrix_components_params_types')->insert([
			'NAME_RU'   => 'Чекбокс',
			'NAME_EN'   => 'Checkbox',
			'FORM_TYPE' => 'CHECKBOX',
		]);
		DB::table('bitrix_components_params_types')->insert([
			'NAME_RU'   => 'Файл',
			'NAME_EN'   => 'File',
			'FORM_TYPE' => 'FILE',
		]);
		//DB::table('bitrix_modules_options_types')->insert([
		//	'NAME_RU'   => 'Свой',
		//	'NAME_EN'   => 'Custom',
		//	'FORM_TYPE' => 'CUSTOM',
		//]);

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

		Model::reguard();
	}
}
