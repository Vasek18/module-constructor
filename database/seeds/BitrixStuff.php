<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BitrixStuff extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();

		// я // todo del
		DB::table('users')->insert([
			'first_name'     => 'Вася',
			'last_name'      => 'Аристов',
			'email'          => 'aristov-92@mail.ru',
			'password'       => bcrypt("12345678"),
			'remember_token' => str_random(10),
		]);


		// типы опций для страницы настройки модулей
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Строка',
			'NAME_EN'   => 'String',
			'FORM_TYPE' => 'text',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Многострочный текст',
			'NAME_EN'   => 'Text',
			'FORM_TYPE' => 'textarea',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Селект',
			'NAME_EN'   => 'Select',
			'FORM_TYPE' => 'selectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Множественный селект',
			'NAME_EN'   => 'Multi select',
			'FORM_TYPE' => 'multiselectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Чекбокс',
			'NAME_EN'   => 'Checkbox',
			'FORM_TYPE' => 'checkbox',
		]);

		// типы опций для arParams компоненты
		DB::table('bitrix_components_params_types')->insert([
			'NAME_RU'   => 'Селект',
			'NAME_EN'   => 'Select',
			'FORM_TYPE' => 'LIST',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Строка',
			'NAME_EN'   => 'String',
			'FORM_TYPE' => 'STRING',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'   => 'Чекбокс',
			'NAME_EN'   => 'Checkbox',
			'FORM_TYPE' => 'CHECKBOX',
		]);
		DB::table('bitrix_modules_options_types')->insert([
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
			'code' => 'BASE',
			'sort' => 100,
			'desc' => 'Основные параметры.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'DATA_SOURCE',
			'sort' => 200,
			'desc' => 'Тип и ID инфоблока.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'VISUAL',
			'sort' => 300,
			'desc' => 'Редко используемая группа. Сюда предполагается загонять параметры, отвечающие за внешний вид.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'URL_TEMPLATES',
			'sort' => 400,
			'desc' => 'Шаблоны ссылок',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'SEF_MODE',
			'sort' => 500,
			'desc' => 'Группа для всех параметров, связанных с использованием ЧПУ.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'AJAX_SETTINGS',
			'sort' => 550,
			'desc' => 'Все, что касается ajax.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'CACHE_SETTINGS',
			'sort' => 600,
			'desc' => 'Появляется при указании параметра CACHE_TIME.',
			'standard' => true
		]);
		DB::table('bitrix_components_params_groups')->insert([
			'code' => 'ADDITIONAL_SETTINGS',
			'sort' => 700,
			'desc' => 'Эта группа появляется, например, при указании параметра SET_TITLE.',
			'standard' => true
		]);

		Model::reguard();
	}
}
