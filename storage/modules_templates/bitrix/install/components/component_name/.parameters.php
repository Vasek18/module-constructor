<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$iblocks = function (){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("{LANG_KEY}_SELECT");
	$rsIBlocks = CIBlock::GetList(array('IBLOCK_TYPE' => 'ASC', 'ID' => 'ASC'));
	while ($arIBlock = $rsIBlocks->Fetch()){
		$select[$arIBlock["ID"]] = $arIBlock["NAME"];
	}

	return $select;
};

// собираем свойства
$iblock_props = function ($IBLOCK_ID){
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
$iblock_items = function ($IBLOCK_ID){
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

$arComponentParameters = array(
	"GROUPS" => array(
		{GROUPS}
	),
	"PARAMETERS" => array(
		{PARAMS}
	),
);
?>
