<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("TEST_TEST_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("TEST_TEST_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/regions.gif",
	"SORT" => 500,
	"PATH" => array(
		"ID" => "test_test_components",
		"SORT" => 500,
		"NAME" => GetMessage("TEST_TEST_COMPONENTS_FOLDER_NAME"),
	),
);

?>