<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;

class BitrixAdminMenuFilesTest extends TestCase{

	use DatabaseTransactions;

	function createAdminPageOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/create');

		if (!isset($inputs['name'])){
			$inputs['name'] = 'Ololo';
		}
		if (!isset($inputs['code'])){
			$inputs['code'] = 'trololo';
		}
		if (!isset($inputs["sort"])){
			$inputs['sort'] = "334";
		}
		if (!isset($inputs["text"])){
			$inputs['text'] = "item";
		}
		if (!isset($inputs["parent_menu"])){
			$inputs['parent_menu'] = 'global_menu_settings';
		}

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixAdminMenuItems::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function removeAdminPage($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/');
		$this->click('delete_amp_'.$amp->id);
	}

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/admin/menu.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	function getGlobalMenuArrays($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/admin/menu.php');
		// dd($installationFileContent);
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'global_menu_'.$module->class_name);
		// dd($gottenInstallationFuncCode);

		preg_match_all('/(\$aModuleMenu\[\] \= [^\;]+;)/is', $gottenInstallationFuncCode, $matches);
		// dd($matches[1]);

		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			// dd(vArrParse::parseFromText($gottenInstallationFuncCodePart));
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	/** @test */
	function it_writes_menu_arr_for_one_page(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$gottenMenuArray = $this->getGlobalMenuArrays($module);
		$fileLangArr = $this->getLangFileArray($module);
		$pageContent = $this->disk()->get($module->module_folder.'/admin/'.$module->class_name."_trololo.php");
		$pageLangContent = $this->disk()->get($module->module_folder.'/lang/ru/admin/'.$module->class_name."_trololo.php");
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_settings",
			"url"         => $module->class_name."_trololo.php",
		];

		$this->assertEquals(1, count($gottenMenuArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenMenuArray[0]);
		$this->assertArrayHasKey($amp->lang_key.'_TEXT', $fileLangArr);
		$this->assertEquals('item', $fileLangArr[$amp->lang_key.'_TEXT']);
		$this->assertArrayHasKey($amp->lang_key.'_TITLE', $fileLangArr);
		$this->assertEquals('item', $fileLangArr[$amp->lang_key.'_TITLE']);
		$this->assertEquals('<a href="test">test</a>', $pageContent);
		$this->assertEquals('<? $MESS["TEST"] = "test"; ?>', $pageLangContent);
	}

	/** @test */
	function it_writes_menu_arr_for_two_pages(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);
		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$amp2 = $this->createAdminPageOnForm($module, [
			'name'        => 'Test',
			'code'        => 'ert',
			"sort"        => "3242",
			"text"        => "olllk",
			"parent_menu" => "global_menu_services",
			"php_code"    => '',
			"lang_code"   => ''
		]);

		$gottenMenuArray = $this->getGlobalMenuArrays($module);
		$fileLangArr = $this->getLangFileArray($module);
		$pageContent = $this->disk()->get($module->module_folder.'/admin/'.$module->class_name."_trololo.php");
		$pageLangContent = $this->disk()->get($module->module_folder.'/lang/ru/admin/'.$module->class_name."_trololo.php");
		$pageContent2 = $this->disk()->get($module->module_folder.'/admin/'.$module->class_name."_ert.php");
		$pageLangContent2 = $this->disk()->get($module->module_folder.'/lang/ru/admin/'.$module->class_name."_ert.php");
		$module->deleteFolder();

		$expectedMenuArray = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_settings",
			"url"         => $module->class_name."_trololo.php",
		];
		$expectedMenuArray2 = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp2->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp2->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_services",
			"url"         => $module->class_name."_ert.php",
		];

		$this->assertEquals(2, count($gottenMenuArray));
		$this->assertEquals($expectedMenuArray, $gottenMenuArray[0]);
		$this->assertEquals($expectedMenuArray2, $gottenMenuArray[1]);
		$this->assertArrayHasKey($amp->lang_key.'_TEXT', $fileLangArr);
		$this->assertEquals('item', $fileLangArr[$amp->lang_key.'_TEXT']);
		$this->assertArrayHasKey($amp->lang_key.'_TITLE', $fileLangArr);
		$this->assertEquals('item', $fileLangArr[$amp->lang_key.'_TITLE']);
		$this->assertArrayHasKey($amp2->lang_key.'_TEXT', $fileLangArr);
		$this->assertEquals('olllk', $fileLangArr[$amp2->lang_key.'_TEXT']);
		$this->assertArrayHasKey($amp2->lang_key.'_TITLE', $fileLangArr);
		$this->assertEquals('olllk', $fileLangArr[$amp2->lang_key.'_TITLE']);
		$this->assertEquals('<a href="test">test</a>', $pageContent);
		$this->assertEquals('<? $MESS["TEST"] = "test"; ?>', $pageLangContent);
		$this->assertEquals('', $pageContent2);
		$this->assertEquals('', $pageLangContent2);
	}

	/** @test */
	function it_remove_admin_folder_if_there_is_no_more_pages(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$this->removeAdminPage($module, $amp);

		$this->assertFalse(file_exists($module->getFolder(true).'/admin/'.$module->class_name."_trololo.php"));
		$this->assertFalse(file_exists($module->getFolder(true).'/admin/menu.php'));
		$this->assertFalse(file_exists($module->getFolder(true).'/lang/ru/admin/'.$module->class_name."_trololo.php"));

		$module->deleteFolder();
	}
}

?>