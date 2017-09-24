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
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::getFullCode($installationFileContent, 'createNecessaryUserFields');
		// dd($gottenInstallationFuncCode);

		preg_match_all('/\$this\-\>createUserField\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches);

		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = explode(', ', $gottenInstallationFuncCodePart);
		}

		return $answer;
	}


	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	/** @test */
	function at_first_there_is_no_optional_functions(){
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$this->assertFalse(strpos($installationFileContent, 'function createUserField'));
		$this->assertFalse(strpos($installationFileContent, 'function removeUserField'));
	}

	/** @test */
	function it_saves_mailevent_creation_code(){
		// $user_field = $this->createUserFieldOnForm($this->module, [
		// 	"entity_id"           => "USER",
		// 	"field_name"          => "UF_TEST",
		// 	"edit_form_label[ru]" => "Test"
		// ]);
		//
		// $gottenInstallationFuncCodeArray = $this->getUserFieldsCreationFuncCallParamsArray($this->module);
		// $installFileLangArr = $this->getLangFileArray($this->module);
		// $installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		//
		// $expectedInstallationFuncCodeArray = [
		// 	'"TEST_MAIL"',
		// 	'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME")',
		// 	'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_DESC")',
		// 	'1808',
		// ];
		//
		// $this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		// $this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		//
		// $this->assertArrayHasKey($this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME', $installFileLangArr);
		// $this->assertEquals($installFileLangArr[$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME'], 'TestMail');
		//
		//
		// // проверка, что есть вспомогательные функции
		// $this->assertNotFalse(strpos($installationFileContent, 'function createUserField'));
		// $this->assertNotFalse(strpos($installationFileContent, 'function removeUserField'));
	}

}

?>