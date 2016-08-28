<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;

class BitrixMailEventsFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/mail_events';

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	function getMailEventsCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::getFullCode($installationFileContent, 'createNecessaryMailEvents');
		// dd($gottenInstallationFuncCode);

		preg_match_all('/\$this\-\>createMailEvent\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
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

		$this->assertFalse(strpos($installationFileContent, 'function createMailEvent'));
		$this->assertFalse(strpos($installationFileContent, 'function createMailTemplate'));
		$this->assertFalse(strpos($installationFileContent, 'function deleteMailEvent'));
	}

	/** @test */
	function it_saves_mailevent_creation_code(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808'
		]);

		$gottenInstallationFuncCodeArray = $this->getMailEventsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			'"TEST_MAIL"',
			'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME")',
			'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_DESC")',
			'1808',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);

		$this->assertArrayHasKey($this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME'], 'TestMail');

		$this->assertNotFalse(strpos($installationFileContent, 'function createMailEvent'));
		$this->assertNotFalse(strpos($installationFileContent, 'function deleteMailEvent'));
	}
}

?>