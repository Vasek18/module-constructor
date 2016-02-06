<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BitrixModulesOptionsTypesSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'     => 'Строка',
			'NAME_EN'    => 'String',
			'FORM_TYPE' => 'text',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'     => 'Многострочный текст',
			'NAME_EN'    => 'Text',
			'FORM_TYPE' => 'textarea',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'     => 'Селект',
			'NAME_EN'    => 'Select',
			'FORM_TYPE' => 'selectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'     => 'Множественный селект',
			'NAME_EN'    => 'Multi select',
			'FORM_TYPE' => 'multiselectbox',
		]);
		DB::table('bitrix_modules_options_types')->insert([
			'NAME_RU'     => 'Чекбокс',
			'NAME_EN'    => 'Checkbox',
			'FORM_TYPE' => 'checkbox',
		]);
		Model::reguard();
	}
}
