<?php

function createUserField($arFields){
	$oUserTypeEntity = new \CUserTypeEntity();

	return $oUserTypeEntity->Add($arFields);
}

function removeUserField($code){
	$oUserTypeEntity = new \CUserTypeEntity();

	$rsData = \CUserTypeEntity::GetList(
		array($by => $order),
		array('FIELD_NAME' => $code)
	);
	while ($arRes = $rsData->Fetch()){
		$oUserTypeEntity->Delete($arRes['ID']);
	}
}
