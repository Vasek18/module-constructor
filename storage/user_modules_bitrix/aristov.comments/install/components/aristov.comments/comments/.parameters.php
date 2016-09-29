<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$iblocks_types_list = function (){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("ARISTOV_COMMENTS_SELECT");
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
	$select[] = GetMessage("ARISTOV_COMMENTS_SELECT");
	$filter = Array();
	$filter["TYPE"] = $IBLOCK_TYPE != "-" ? $IBLOCK_TYPE : "";
	$rsIBlocks = CIBlock::GetList(array('NAME' => 'ASC'), $filter);
	while ($arIBlock = $rsIBlocks->Fetch()){
		$select[$arIBlock["ID"]] = $arIBlock["NAME"];
	}

	return $select;
};

// sobiraem_svoystva
$iblock_props_list = function ($IBLOCK_ID){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("ARISTOV_COMMENTS_SELECT");
	$properties = CIBlockProperty::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
	while ($prop_fields = $properties->GetNext()){
		$select[$prop_fields["CODE"]] = $prop_fields["NAME"];
	}

	return $select;
};

// sobiraem_elementy
$iblock_items_list = function ($IBLOCK_ID){
	CModule::IncludeModule("iblock");
	$select = Array();
	$select[] = GetMessage("ARISTOV_COMMENTS_SELECT");
	$rs = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID), false, false, Array("ID", "CODE", "NAME"));
	while ($ob = $rs->GetNextElement()){
		$arFields = $ob->GetFields();
		$select[$arFields["ID"]] = $arFields["NAME"];
	}

	return $select;
};

$arComponentParameters = array(
	"GROUPS" => array(

	),
	"PARAMETERS" => array(
		"ELEMENT_IBLOCK_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_ELEMENT_IBLOCK_ID_NAME"),
			"TYPE" => "LIST",
			"REFRESH" => "Y",
			"VALUES" => $iblocks_list($arCurrentValues["ELEMENT_IBLOCK_TYPE"])
		),
		"ELEMENT_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_ELEMENT_ID_NAME"),
			"TYPE" => "STRING",
			"REFRESH" => "Y",
			'DEFAULT' => '={$_REQUEST["id"]}',
		),
		"ELEMENT_CODE"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_ELEMENT_CODE_NAME"),
			"TYPE" => "STRING",
			"REFRESH" => "Y",
			'DEFAULT' => '={$_REQUEST["code"]}',
		),
		"CACHE_TIME"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_CACHE_TIME_NAME"),
			"TYPE" => "STRING",
			"REFRESH" => "Y",
			'DEFAULT' => '3600',
		),
		"IBLOCK_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_IBLOCK_ID_NAME"),
			"TYPE" => "LIST",
			"REFRESH" => "Y",
			"VALUES" => $iblocks_list()
		),
		"AUTHOR_PROP"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_AUTHOR_PROP_NAME"),
			"TYPE" => "LIST",
			"VALUES" => $iblock_props_list($arCurrentValues["IBLOCK_ID"])
		),
		"PARENT_PROP"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ARISTOV_COMMENTS_PARAM_PARENT_PROP_NAME"),
			"TYPE" => "LIST",
			"VALUES" => $iblock_props_list($arCurrentValues["IBLOCK_ID"])
		)

	),
);
?>
