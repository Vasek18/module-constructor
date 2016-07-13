<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/regions.gif",
	"SORT" => {COMPONENT_SORT},
	"PATH" => array(
		"ID" => "{MODULE_COMPONENTS_FOLDER_ID}",
		"SORT" => {MODULE_COMPONENTS_FOLDER_SORT},
		"NAME" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENTS_FOLDER_NAME"),
	),
);

?>