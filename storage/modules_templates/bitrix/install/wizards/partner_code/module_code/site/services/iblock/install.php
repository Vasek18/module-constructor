<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock")){
    return;
}

$lang = (in_array(LANGUAGE_ID, array("ru", "en", "de"))) ? LANGUAGE_ID : \Bitrix\Main\Localization\Loc::getDefaultLang(LANGUAGE_ID);

$pathToBitrixFolder = substr(__DIR__, 0, strpos(__DIR__, 'wizards'));
require $pathToBitrixFolder.'/modules/{MODULE_ID}/install/index.php';

$module = new {MODULE_CLASS_NAME};
$module->InstallDB();