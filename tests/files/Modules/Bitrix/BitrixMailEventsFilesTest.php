<?php

// use Illuminate\Foundation\Testing\DatabaseTransactions;
// use App\Models\Modules\Bitrix\BitrixComponent;
// use App\Helpers\vArrParse;
// use App\Models\Modules\Bitrix\BitrixComponentsParams;
// use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
// use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;
//
// class BitrixMailEventsFilesTest extends BitrixTestCase{
//
// 	use DatabaseTransactions;
//
// 	protected $path = '/mail_events';
//
// 	function setUp(){
// 		parent::setUp();
//
// 		$this->signIn();
// 		$this->module = $this->fillNewBitrixForm();
// 	}
//
// 	function tearDown(){
// 		parent::tearDown();
//
// 		$this->module->deleteFolder();
// 	}
//
// 	function getMailEventCreationFuncCallParamsArray($module){
// 		$answer = [];
// 		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
// 		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryMailEvents');
// 		// dd($installationFileContent);
//
// 		preg_match_all('/(\$this\-\>createIblock\([^\;]+\);)/is', $gottenInstallationFuncCode, $matches);
//
// 		foreach ($matches[1] as $gottenInstallationFuncCodePart){
// 			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
// 		}
//
// 		return $answer;
// 	}
//
// 	/** @test */
// 	function it_creates_standard_component(){
// 		$mail_event = $this->createMailEventOnForm($this->module, [
// 			'name' => 'TestMail',
// 			'code' => 'TEST_MAIL',
// 			'sort' => '1808',
// 			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
// 		]);
//
// 		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
// 		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
// 		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');
//
// 		$this->deleteFolder($this->standartModuleCode);
//
// 		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
// 		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
// 		$this->assertEquals('HelloWorld', $description_lang_arr[$component->lang_key."_COMPONENT_DESCRIPTION"]);
// 		$this->assertEquals('334', $description_arr["SORT"]);
// 	}
// }

?>