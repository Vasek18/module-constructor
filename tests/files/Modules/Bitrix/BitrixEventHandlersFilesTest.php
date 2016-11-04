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
	function it_saves_event_handler_with_params(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'params'      => '$arFields',
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
	static public function Handler($arFields){
		<?="ololo";?>
	}

}'));
	}

	/** @test */
	function it_saves_event_handler_with_multiple_events(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module'  => 'main',
			'event'        => 'OnProlog',
			'from_module1' => 'iblock',
			'event1'       => 'OnAfterIBlockElementAdd',
			'class'        => 'MyClass',
			'method'       => 'Handler',
			'php_code'     => '<?="ololo";?>',
		]);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		// dd($installationArr);
		$file = file_get_contents($this->module->getFolder().'/lib/eventhandlers/myclass.php');

		$expectedArr = [
			"main",
			"OnProlog",
			'$this->MODULE_ID',
			'\\'.$this->module->namespace.'\EventHandlers\MyClass',
			"Handler",
		];
		$expectedArr1 = [
			"iblock",
			"OnAfterIBlockElementAdd",
			'$this->MODULE_ID',
			'\\'.$this->module->namespace.'\EventHandlers\MyClass',
			"Handler",
		];

		$this->assertEquals($expectedArr, $installationArr[0]);
		$this->assertEquals($expectedArr1, $installationArr[1]);

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

	// /** @test */ // нет смысла, так как мы не работаем по id
	// function it_cannot_edit_anothers_module_event_handler(){
	// }

	/** @test */
	function it_deletes_last_event_handler(){
		$handler = $this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);

		$this->click('delete_handler_'.$handler->id);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		$expectedArr = [];
		$this->assertEquals($expectedArr, $installationArr);

		$this->assertFileNotExists($this->module->getFolder().'/lib/eventhandlers/myclass.php');
	}

	/** @test */
	function it_deletes_not_last_event_handler(){
		$handler = $this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);
		$handler2 = $this->createEventHandlerOnForm($this->module, 1, [
			'from_module' => 'test',
			'event'       => 'OnTest',
			'class'       => 'MySuperClass',
			'method'      => 'UltimateHandler',
			'php_code'    => '<?="trololo";?>',
		]);

		$this->click('delete_handler_'.$handler2->id);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		$file = file_get_contents($this->module->getFolder().'/lib/eventhandlers/myclass.php');
		$expectedArr = [
			[
				"main",
				"OnProlog",
				'$this->MODULE_ID',
				'\\'.$this->module->namespace.'\EventHandlers\MyClass',
				"Handler",
			]
		];

		$this->assertEquals($expectedArr, $installationArr);

		$this->assertEquals(preg_split('/\r\n|\r|\n/', $file),
			preg_split('/\r\n|\r|\n/', '<?
namespace '.$this->module->namespace.'\EventHandlers;

class MyClass{
	static public function Handler(){
		<?="ololo";?>
	}

}'));

		$this->assertFileNotExists($this->module->getFolder().'/lib/eventhandlers/mysuperclass.php');
	}

	/** @test */
	function it_cannot_delete_anothers_module_event_handler(){
		$handler = $this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/delete/'.$handler->id);

		$installationArr = $this->getEventHandlersCreationFuncCallParamsArray($this->module);
		$expectedArr = [
			[
				"main",
				"OnProlog",
				'$this->MODULE_ID',
				'\\'.$this->module->namespace.'\EventHandlers\MyClass',
				"Handler",
			]
		];
		$this->assertEquals($expectedArr, $installationArr);

		$this->assertFileExists($this->module->getFolder().'/lib/eventhandlers/myclass.php');
	}

	/** @test */
	function it_doesnt_duplicates_event_handlers_function(){
		$handler1 = $this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);
		$handler2 = $this->createEventHandlerOnForm($this->module, 1, [
			'from_module' => 'main',
			'event'       => 'OnEpilog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="trololo";?>',
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
		$expectedArr2 = [
			"main",
			"OnEpilog",
			'$this->MODULE_ID',
			'\\'.$this->module->namespace.'\EventHandlers\MyClass',
			"Handler",
		];

		$this->assertEquals($expectedArr, $installationArr[0]);
		$this->assertEquals($expectedArr2, $installationArr[1]);

		$this->assertEquals(preg_split('/\r\n|\r|\n/', $file),
			preg_split('/\r\n|\r|\n/', '<?
namespace '.$this->module->namespace.'\EventHandlers;

class MyClass{
	static public function Handler(){
		<?="ololo";?>
	}

}'));
	}
}

?>