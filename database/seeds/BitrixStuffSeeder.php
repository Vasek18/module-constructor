<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Bitrix\BitrixHelperFunctions;

class BitrixStuffSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();

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

		// функции, которые я использую, для сборы данных на стороне Битрикса

		// список типов инфоблоков
		DB::table('bitrix_helper_functions')->insert([
			'is_closure' => true,
			'name'       => 'iblocks_types_list',
			'body'       => '
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$rsIBlocks = CIBlockType::GetList(array("IBLOCK_TYPE" => "ASC", "ID" => "ASC"));
	while ($arIBlock = $rsIBlocks->Fetch()){
		if ($arIBType = CIBlockType::GetByIDLang($arIBlock["ID"], LANG)){
			$select[$arIBlock["ID"]] = htmlspecialcharsEx($arIBType["NAME"]);
		}
	}

	return $select;
']);

		// список инфоблоков
		DB::table('bitrix_helper_functions')->insert([
			'is_closure' => true,
			'name'       => 'iblocks_list',
			'body'       => '
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$filter = Array();
	$filter["TYPE"] = $IBLOCK_TYPE != "-" ? $IBLOCK_TYPE : "";
	$rsIBlocks = CIBlock::GetList(array("NAME" => "ASC"), $filter);
	while ($arIBlock = $rsIBlocks->Fetch()){
		$select[$arIBlock["ID"]] = $arIBlock["NAME"];
	}

	return $select;
']);
		DB::table('bitrix_helper_functions_args')->insert([
				'function_id' => BitrixHelperFunctions::where('name', 'iblocks_list')->first()->id,
				'name'        => 'IBLOCK_TYPE']
		);

		// собираем свойства
		DB::table('bitrix_helper_functions')->insert([
			'is_closure' => true,
			'name'       => 'iblock_props_list',
			'body'       => '
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$properties = CIBlockProperty::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
	while ($prop_fields = $properties->GetNext()){
		$select[$prop_fields["CODE"]] = $prop_fields["NAME"];
	}

	return $select;
']);
		DB::table('bitrix_helper_functions_args')->insert([
				'function_id' => BitrixHelperFunctions::where('name', 'iblock_props_list')->first()->id,
				'name'        => 'IBLOCK_ID']
		);

		// собираем элементы
		DB::table('bitrix_helper_functions')->insert([
			'is_closure' => true,
			'name'       => 'iblock_items_list',
			'body'       => '
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$rs = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID), false, false, Array("ID", "CODE", "NAME"));
	while ($ob = $rs->GetNextElement()){
		$arFields = $ob->GetFields();
		$select[$arFields["ID"]] = $arFields["NAME"];
	}

	return $select;
']);
		DB::table('bitrix_helper_functions_args')->insert([
				'function_id' => BitrixHelperFunctions::where('name', 'iblock_items_list')->first()->id,
				'name'        => 'IBLOCK_ID']
		);

		Model::reguard();
	}
}
