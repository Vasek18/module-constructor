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

	function getTemplatesCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::getFullCode($installationFileContent, 'createNecessaryMailEvents');
		// dd($gottenInstallationFuncCode);

		preg_match_all('/\$this\-\>createMailTemplate\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches);

		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
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

	/** @test */
	function it_saves_mailevent_with_vars_creation_code(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'TROLOLO']
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

		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME'], 'TestMail');

		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_DESC'], '#TROLOLO# - Ololo'.PHP_EOL);

		$this->assertNotFalse(strpos($installationFileContent, 'function createMailEvent'));
		$this->assertNotFalse(strpos($installationFileContent, 'function deleteMailEvent'));
	}

	/** @test */
	function it_saves_mailevent_with_template_creation_code(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
		]);
		$template = $this->createMailEventTemplateOnForm(
			$this->module,
			$mail_event,
			[
				'name'        => 'TestTemplate',
				'from'        => 'me',
				'to'          => '#YOU#',
				'copy'        => '#HIM#',
				'hidden_copy' => '#FSB#',
				'reply_to'    => 'me',
				'in_reply_to' => 'In?',
				'theme'       => 'Hi',
				'body'        => 'Ololo',
			]);

		$gottenInstallationFuncCodeArray = $this->getMailEventsCreationFuncCallParamsArray($this->module);
		$gottenTemplatesInstallationFuncCodeArray = $this->getTemplatesCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			'"TEST_MAIL"',
			'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME")',
			'Loc::getMessage("'.$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_DESC")',
			'1808',
		];
		$expectedTemplateInstallationFuncCodeArray = [
			"EVENT_NAME" => "TEST_MAIL",
			"EMAIL_FROM" => "me",
			"EMAIL_TO"   => "#YOU#",
			"BCC"        => "#FSB#",
			"SUBJECT"    => 'Loc::getMessage("'.$mail_event->lang_key.'_TEMPLATE_'.$template->id.'_THEME")',
			"BODY_TYPE"  => "html",
			"MESSAGE"    => 'Loc::getMessage("'.$mail_event->lang_key.'_TEMPLATE_'.$template->id.'_BODY")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);

		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_MAIL_EVENT_TEST_MAIL_NAME'], 'TestMail');

		$this->assertEquals($expectedTemplateInstallationFuncCodeArray, $gottenTemplatesInstallationFuncCodeArray[0]);

		$this->assertEquals($installFileLangArr[$mail_event->lang_key.'_TEMPLATE_'.$template->id.'_THEME'], 'Hsi');
		$this->assertEquals($installFileLangArr[$mail_event->lang_key.'_TEMPLATE_'.$template->id.'_BODY'], 'Ololo');

		$this->assertNotFalse(strpos($installationFileContent, 'function createMailEvent'));
		$this->assertNotFalse(strpos($installationFileContent, 'function deleteMailEvent'));
		$this->assertNotFalse(strpos($installationFileContent, 'function createMailTemplate'));
	}

	/** @test */
	function it_deletes_mailevent(){

	}

	/** @test */
	function it_deletes_mailevent_with_template(){

	}

	/** @test */
	function it_deletes_template(){

	}

	/** @test */
	function it_deletes_var(){

	}
}

?>