<?
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

AddEventHandler("main", "OnBuildGlobalMenu", "global_menu_{MODULE_CLASS_NAME}");

function global_menu_{MODULE_CLASS_NAME}(&$aGlobalMenu, &$aModuleMenu){
	
}
?>