<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
if (!defined("WIZARD_DEFAULT_SITE_ID") && !empty($_REQUEST["wizardSiteID"]))
    define("WIZARD_DEFAULT_SITE_ID", $_REQUEST["wizardSiteID"]);

$arWizardDescription = Array(
    "NAME"        => GetMessage("{LANG_KEY}_WIZARD_NAME"),
    "DESCRIPTION" => GetMessage("{LANG_KEY}_WIZARD_DESC"),
    "VERSION"     => "{VERSION}",
    "START_TYPE"  => "WINDOW",
    "WIZARD_TYPE" => "INSTALL",
    "IMAGE"       => "/images/".LANGUAGE_ID."/solution.png",
    "PARENT"      => "wizard_sol",
    "TEMPLATES"   => Array(
        Array("SCRIPT" => "wizard_sol")
    ),
    "STEPS"       => (
    defined("WIZARD_DEFAULT_SITE_ID") ?
        Array(
            "SelectTemplateStep",
            "SelectThemeStep",
            "SiteSettingsStep",
            "DataInstallStep",
            "FinishStep"
        ) :
        Array(
            "SelectSiteStep",
            "SelectTemplateStep",
            "SelectThemeStep",
            "SiteSettingsStep",
            "DataInstallStep",
            "FinishStep"
        )
    )
);
?>