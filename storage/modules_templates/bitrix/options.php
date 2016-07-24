<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

$module_id = '{MODULE_ID}';

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight($module_id) < "S"){
	$APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}

\Bitrix\Main\Loader::includeModule($module_id);

$request = \Bitrix\Main\HttpApplication::getInstance()->getContext()->getRequest();

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

$aTabs = array(
	array(
		'DIV'     => 'props',
		'TAB'     => Loc::getMessage('{LANG_KEY}_TAB_SETTINGS'),
		'OPTIONS' => array({OPTIONS})
	),
	array(
		"DIV"     => "rights",
		"TAB"     => Loc::getMessage("MAIN_TAB_RIGHTS"),
		"TITLE"   => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS"),
		"OPTIONS" => Array()
	),
);
#Сохранение

if ($request->isPost() && $request['Apply'] && check_bitrix_sessid()){

	foreach ($aTabs as $aTab){
		foreach ($aTab['OPTIONS'] as $arOption){
			if (!is_array($arOption))
				continue;

			if ($arOption['note'])
				continue;


			$optionName = $arOption[0];

			$optionValue = $request->getPost($optionName);

			Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
		}
	}
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

?>
<? $tabControl->Begin(); ?>
<form method='post'
	  action='<? echo $APPLICATION->GetCurPage() ?>?mid=<?=htmlspecialcharsbx($request['mid'])?>&amp;lang=<?=$request['lang']?>'
	  name='{MODULE_CLASS_NAME}_settings'>

	<? foreach ($aTabs as $aTab):
		if ($aTab['OPTIONS']):?>
			<? $tabControl->BeginNextTab(); ?>
			<? __AdmSettingsDrawList($module_id, $aTab['OPTIONS']); ?>

		<? endif;
	endforeach; ?>

	<?
	$tabControl->BeginNextTab();

	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");

	$tabControl->Buttons(); ?>

	<input type="submit" name="Apply" value="<? echo GetMessage('MAIN_SAVE') ?>">
	<input type="reset" name="reset" value="<? echo GetMessage('MAIN_RESET') ?>">
	<?=bitrix_sessid_post();?>
</form>
<? $tabControl->End(); ?>

