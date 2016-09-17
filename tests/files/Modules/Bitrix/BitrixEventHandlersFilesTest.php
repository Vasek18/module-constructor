<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

class BitrixEventHandlersFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/events_handlers';

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	function getEventHandlersCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::getFullCode($installationFileContent, 'InstallEvents');
		// dd($gottenInstallationFuncCode);

		preg_match_all('/\-\>registerEventHandler\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches);

		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$params = explode(', ', $gottenInstallationFuncCodePart);
			foreach ($params as $c => $param){
				$params[$c] = preg_replace('/[\'\"]*([^\'\"].+[^\'\"])[\'\"]*/', '$1', $param);
			}
			$answer[] = $params;
		}

		return $answer;
	}

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	/** @test */
	function it_saves_event_handler(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		// $langArr = $this->getLangFileArray($this->module);
		$file = file_get_contents($this->module->getFolder().'/lib/eventhandlers/myclass.php');

		$expectedArr = [
			"main",
			"OnProlog",
			'$this->MODULE_ID',
			'\\'.$this->module->namespace.'\EventHandlers\MyClass',
			"Handler",
		];

		$this->assertEquals($expectedArr, $installationArr[0]);

		$this->assertEquals(preg_split('/\r\n|\r|\n/', $file),
			preg_split('/\r\n|\r|\n/', '<?
namespace '.$this->module->namespace.'\EventHandlers;

class MyClass{
	static public function Handler(){
		<?="ololo";?>
	}

}'));
	}

	/** @test */
	function it_edits_event_handler(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'test',
			'event'       => 'OnTest',
			'class'       => 'MySuperClass',
			'method'      => 'UltimateHandler',
			'php_code'    => '<?="trololo";?>',
		]);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		// $langArr = $this->getLangFileArray($this->module);
		$file = file_get_contents($this->module->getFolder().'/lib/eventhandlers/mysuperclass.php');

		$expectedArr = [
			"test",
			"OnTest",
			'$this->MODULE_ID',
			'\\'.$this->module->namespace.'\EventHandlers\MySuperClass',
			"UltimateHandler",
		];

		$this->assertEquals($expectedArr, $installationArr[0]);

		$this->assertEquals(preg_split('/\r\n|\r|\n/', $file),
			preg_split('/\r\n|\r|\n/', '<?
namespace '.$this->module->namespace.'\EventHandlers;

class MySuperClass{
	static public function UltimateHandler(){
		<?="trololo";?>
	}

}'));
		$this->assertFileNotExists($this->module->getFolder().'/lib/eventhandlers/myclass.php');
	}

	/** @test */
	function it_cannot_edit_anothers_module_event_handler(){
	}

	/** @test */
	function it_deletes_last_event_handler(){
	}

	/** @test */
	function it_deletes_not_last_event_handler(){
	}

	/** @test */
	function it_cannot_delete_anothers_module_event_handler(){
	}
}

?>