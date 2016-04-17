<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENT"),
	"ICON" => "/images/regions.gif",
	"SORT" => {COMPONENT_SORT},
	"PATH" => array(
		"ID" => "{MODULE_COMPONENTS_FOLDER_ID}",
		"SORT" => {MODULE_COMPONENTS_FOLDER_SORT},
		"NAME" => GetMessage("{LANG_KEY}_COMPONENTS_FOLDER_NAME"),
		"CHILD" => array(
			"ID" => "{MODULE_COMPONENTS_SUBFOLDER_ID}",
			"NAME" => GetMessage("{COMPONENT_LANG_KEY}_COMPONENTS_SUBFOLDER_NAME"),
			"SORT" => {MODULE_COMPONENTS_SUBFOLDER_SORT},
		)
	),
);

?>