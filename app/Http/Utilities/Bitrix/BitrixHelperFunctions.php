<?php


// надо бы хранить их все в файлах
// тем более, что инфоблоки по-моему как раз лишь файлы используют
namespace App\Http\Utilities\Bitrix;

class BitrixHelperFunctions{

	public static $functions = [
		// список типов инфоблоков
		'iblocks_types_list' => [
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
'],

		// список инфоблоков
		'iblocks_list'       => [
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
',
			'args'       => [
				['name' => 'IBLOCK_TYPE']
			]
		],

		// собираем свойства
		'iblock_props_list'  => [
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
',
			'args'       => [
				['name' => 'IBLOCK_ID']
			]
		],

		// собираем элементы
		'iblock_items_list'  => [
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
',
			'args'       => [
				['name' => 'IBLOCK_ID']
			]
		],

		// список шаблонов постраничной навигации
		'pager_templates_list'  => [
			'is_closure' => true,
			'name'       => 'pager_templates_list',
			'body'       => '
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");

	$templatesList = CComponentUtil::GetTemplatesList("bitrix:system.pagenavigation");
	foreach ($templatesList as $templateArr){
		$select[$templateArr["NAME"]] = $templateArr["NAME"];
	}

	return $select;
',
		],
	];

	public static function all(){
		return static::$functions;
	}

	public static function getPhpCodeFromListOfFuncsNames($list = []){
		$answer = '';
		$list = array_unique($list);
		foreach ($list as $name){
			if (!$name){
				continue;
			}
			$answer .= BitrixHelperFunctions::php_code($name).';'.PHP_EOL.PHP_EOL;
		}

		return $answer;
	}

	public static function php_code($funcName){
		$function = static::$functions[$funcName];
		$args = '';
		if (isset($function['args'])){
			foreach ($function['args'] as $arg){
				$args .= '$'.$arg['name'];
			}
		}

		return $code = '$'.$function['name'].' = function('.$args.'){'.$function['body'].'}';
	}
}