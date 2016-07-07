<?php
function createIblockType(){
	global $DB, $APPLICATION;
	CModule::IncludeModule("iblock");

	$iblockType = "{MODULE_CLASS_NAME}_iblock_type";
	$db_iblock_type = CIBlockType::GetList(Array("SORT" => "ASC"), Array("ID" => $iblockType));
	if (!$ar_iblock_type = $db_iblock_type->Fetch()){
		$arFieldsIBT = Array(
			'ID'       => $iblockType,
			'SECTIONS' => 'Y',
			'IN_RSS'   => 'N',
			'SORT'     => 500,
			'LANG'     => Array(
				'en' => Array(
					'NAME' => Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_NAME_EN"),
				),
				'ru' => Array(
					'NAME' => Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_NAME_RU"),
				)
			)
		);

		$obBlocktype = new CIBlockType;
		$DB->StartTransaction();
		$resIBT = $obBlocktype->Add($arFieldsIBT);
		if (!$resIBT){
			$DB->Rollback();
			$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_ALREADY_EXISTS"));
		}else{
			$DB->Commit();

			return $iblockType;
		}
	}
}

function removeIblockType(){
	global $APPLICATION, $DB;
	CModule::IncludeModule("iblock");

	$iblockType = "{MODULE_CLASS_NAME}_iblock_type";

	$DB->StartTransaction();
	if (!CIBlockType::Delete($iblockType)){
		$DB->Rollback();
		$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_DELETION_ERROR"));
	}
	$DB->Commit();
}

function createIblock($params){
	global $APPLICATION;
	CModule::IncludeModule("iblock");

	$ib = new CIBlock;

	$resIBE = CIBlock::GetList(Array(), Array('TYPE' => $params["IBLOCK_TYPE_ID"], 'SITE_ID' => $params["SITE_ID"], "CODE" => $params["CODE"]));
	if ($ar_resIBE = $resIBE->Fetch()){
		$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_ALREADY_EXISTS"));

		return false;
	}else{
		$ID = $ib->Add($params);

		return $ID;
	}

	return false;
}

function createIblockProp($arFieldsProp){
	CModule::IncludeModule("iblock");
	$ibp = new CIBlockProperty;
	return $ibp->Add($arFieldsProp);
}

function createIblockElement($arFields){
	CModule::IncludeModule("iblock");
	$el = new CIBlockElement;

	if ($PRODUCT_ID = $el->Add($arFields)){
		return $PRODUCT_ID;
	}

	return false;
}