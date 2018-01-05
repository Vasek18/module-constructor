<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");

class SelectSiteStep extends CSelectSiteWizardStep{

    function InitStep(){
        parent::InitStep();

        $wizard               =& $this->GetWizard();
        $wizard->solutionName = "{MODULE_CODE}";
    }
}

class SelectTemplateStep extends CSelectTemplateWizardStep{

}

class SelectThemeStep extends CSelectThemeWizardStep{

}

class SiteSettingsStep extends CSiteSettingsWizardStep{

    function InitStep(){
        $wizard               =& $this->GetWizard();
        $wizard->solutionName = "{MODULE_CODE}";
        parent::InitStep();

        $this->SetTitle(GetMessage("wiz_settings"));
        $this->SetNextStep("data_install");
        $this->SetNextCaption(GetMessage("wiz_install"));

        $wizard->SetDefaultVars(
            Array(
                "siteName"        => COption::GetOptionString("main", "site_personal_name", GetMessage("wiz_name"), $wizard->GetVar("siteID")),
                "copyright"       => COption::GetOptionString("main", "site_copyright", GetMessage("wiz_copyright"), $wizard->GetVar("siteID")),
                "installDemoData" => COption::GetOptionString("main", "wizard_demo_data", "N")
            )
        );
    }

    function OnPostForm(){
        $wizard =& $this->GetWizard();

        if ($wizard->IsNextButtonClick()){
            COption::SetOptionString("main", "site_personal_name", str_replace(Array("<"), Array("&lt;"), $wizard->GetVar("siteName")));
            COption::SetOptionString("main", "site_copyright", str_replace(Array("<"), Array("&lt;"), $wizard->GetVar("copyright")));
        }
    }

    function ShowStep(){
        $wizard =& $this->GetWizard();

        $wizard->SetVar("siteName", COption::GetOptionString("main", "site_personal_name", GetMessage("wiz_name"), $wizard->GetVar("siteID")));
        $wizard->SetVar("copyright", COption::GetOptionString("main", "site_copyright", GetMessage("wiz_copyright"), $wizard->GetVar("siteID")));

        $firstStep = COption::GetOptionString("main", "wizard_first".substr($wizard->GetID(), 7)."_".$wizard->GetVar("siteID"), false, $wizard->GetVar("siteID"));
        if ($firstStep == "Y"){
            $this->content .= $this->ShowCheckboxField(
                "installDemoData",
                "Y",
                (array("id" => "installDemoData"))
            );
            $this->content .= '<label for="install-demo-data">'.GetMessage("wiz_structure_data").'</label><br />';
        } else{
            $this->content .= $this->ShowHiddenField("installDemoData", "Y");
        }
    }
}

class DataInstallStep extends CDataInstallWizardStep{

    function CorrectServices(&$arServices){
        $wizard =& $this->GetWizard();
        if ($wizard->GetVar("installDemoData") != "Y"){
        }
    }
}

class FinishStep extends CFinishWizardStep{

}

?>