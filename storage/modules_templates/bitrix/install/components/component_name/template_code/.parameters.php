<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$iblocks_types_list = function (){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$rsIBlocks = CIBlockType::GetList(array('IBLOCK_TYPE' => 'ASC', 'ID' => 'ASC'));
	while ($arIBlock = $rsIBlocks->Fetch()){
		if ($arIBType = CIBlockType::GetByIDLang($arIBlock["ID"], LANG)){
			$select[$arIBlock["ID"]] = htmlspecialcharsEx($arIBType["NAME"]);
		}
	}

	return $select;
};

$iblocks_list = function ($IBLOCK_TYPE){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$filter = Array();
	$filter["TYPE"] = $IBLOCK_TYPE != "-" ? $IBLOCK_TYPE : "";
	$rsIBlocks = CIBlock::GetList(array('NAME' => 'ASC'), $filter);
	while ($arIBlock = $rsIBlocks->Fetch()){
		$select[$arIBlock["ID"]] = $arIBlock["NAME"];
	}

	return $select;
};

// собираем свойства
$iblock_props_list = function ($IBLOCK_ID){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$properties = CIBlockProperty::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
	while ($prop_fields = $properties->GetNext()){
		$select[$prop_fields["CODE"]] = $prop_fields["NAME"];
	}

	return $select;
};

// собираем элементы
$iblock_items_list = function ($IBLOCK_ID){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$rs = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID), false, false, Array("ID", "CODE", "NAME"));
	while ($ob = $rs->GetNextElement()){
		$arFields = $ob->GetFields();
		$select[$arFields["ID"]] = $arFields["NAME"];
	}

	return $select;
};

$arTemplateParameters = array(
		{PARAMS}
);
?>
