<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

/** @group bitrix_files */
class BitrixUserFieldsFilesTest extends BitrixTestCase{

    use DatabaseTransactions;

    protected $path = '/data_storage';

    function setUp(){
        parent::setUp();

        $this->signIn();
        $this->module = $this->fillNewBitrixForm();
    }

    function tearDown(){
        parent::tearDown();

        if ($this->module){
            $this->module->deleteFolder();
        }
    }

    function getUserFieldsCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::getFullCode($installationFileContent, 'createNecessaryUserFields');
        // dd($gottenInstallationFuncCode);

        preg_match_all('/\$this\-\>createUserField\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
        // dd($matches);

        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        //        dd($answer);

        return $answer;
    }

    function getLangFileArray($module, $lang = 'ru'){
        $optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
        $optionsArr         = vArrParse::parseFromText($optionsFileContent, 'MESS');

        return $optionsArr;
    }

    /** @test */
    function at_first_there_is_no_optional_functions(){
        $installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

        $this->assertFalse(strpos($installationFileContent, 'function createUserField'));
        $this->assertFalse(strpos($installationFileContent, 'function removeUserField'));
    }

    /** @test */
    function it_saves_user_field_creation_code(){
        $user_field = $this->createUserFieldOnForm($this->module, [
            "entity_id"           => "USER",
            "field_name"          => "UF_TEST",
            "edit_form_label[ru]" => "Test"
        ]);

        $gottenInstallationFuncCodeArray = $this->getUserFieldsCreationFuncCallParamsArray($this->module);
        $installFileLangArr              = $this->getLangFileArray($this->module);
        $installationFileContent         = file_get_contents($this->module->getFolder(true).'/install/index.php');

        $expectedInstallationFuncCodeArray = [
            "USER_TYPE_ID"      => "string",
            "ENTITY_ID"         => "USER",
            "FIELD_NAME"        => "UF_TEST",
            "XML_ID"            => "",
            "SORT"              => "100",
            "MULTIPLE"          => "N",
            "MANDATORY"         => "N",
            "SHOW_FILTER"       => "N",
            "SHOW_IN_LIST"      => "N",
            "EDIT_IN_LIST"      => "N",
            "IS_SEARCHABLE"     => "N",
            "SETTINGS"          => [
                "DEFAULT_VALUE" => "",
                "SIZE"          => "20",
                "ROWS"          => "1",
                "MIN_LENGTH"    => "0",
                "MAX_LENGTH"    => "0",
                "REGEXP"        => "",
            ],
            "EDIT_FORM_LABEL"   => [
                "ru" => 'Loc::getMessage("'.$this->module->lang_key.'_USER_FIELD_UF_TEST_EDIT_FORM_LABEL")',
            ],
            "LIST_COLUMN_LABEL" => [
                "ru" => 'Loc::getMessage("'.$this->module->lang_key.'_USER_FIELD_UF_TEST_LIST_COLUMN_LABEL")',
            ],
            "LIST_FILTER_LABEL" => [
                "ru" => 'Loc::getMessage("'.$this->module->lang_key.'_USER_FIELD_UF_TEST_LIST_FILTER_LABEL")',
            ],
            "ERROR_MESSAGE"     => [
                "ru" => 'Loc::getMessage("'.$this->module->lang_key.'_USER_FIELD_UF_TEST_ERROR_MESSAGE")',
            ],
            "HELP_MESSAGE"      => [
                "ru" => 'Loc::getMessage("'.$this->module->lang_key.'_USER_FIELD_UF_TEST_HELP_MESSAGE")',
            ],
        ];

        $this->assertEquals(1, count($gottenInstallationFuncCodeArray));
        $this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);

        $this->assertArrayHasKey($this->module->lang_key.'_USER_FIELD_UF_TEST_EDIT_FORM_LABEL', $installFileLangArr);
        $this->assertEquals($installFileLangArr[$this->module->lang_key.'_USER_FIELD_UF_TEST_EDIT_FORM_LABEL'], 'Test');

        // проверка, что есть вспомогательные функции
        $this->assertNotFalse(strpos($installationFileContent, 'function createUserField'));
        $this->assertNotFalse(strpos($installationFileContent, 'function removeUserField'));
    }

}

?>