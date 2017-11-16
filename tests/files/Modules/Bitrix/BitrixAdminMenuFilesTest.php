<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;

/** @group bitrix_files */
class BitrixAdminMenuFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

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
		$amp = $this->createAdminPageOnForm($this->module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$gottenMenuArray = $this->getGlobalMenuArrays($this->module);
		$fileLangArr = $this->getLangFileArray($this->module);
		$pageContent = $this->disk()->get($this->module->module_folder.'/admin/'.$this->module->class_name."_trololo.php");
		$pageLangContent = $this->disk()->get($this->module->module_folder.'/lang/ru/admin/'.$this->module->class_name."_trololo.php");

		$expectedInstallationFuncCodeArray = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_settings",
			"url"         => $this->module->class_name."_trololo.php",
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
		$amp = $this->createAdminPageOnForm($this->module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$amp2 = $this->createAdminPageOnForm($this->module, [
			'name'        => 'Test',
			'code'        => 'ert',
			"sort"        => "3242",
			"text"        => "olllk",
			"parent_menu" => "global_menu_services",
			"php_code"    => '',
			"lang_code"   => ''
		]);

		$gottenMenuArray = $this->getGlobalMenuArrays($this->module);
		$fileLangArr = $this->getLangFileArray($this->module);

		$expectedMenuArray = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_settings",
			"url"         => $this->module->class_name."_trololo.php",
		];
		$expectedMenuArray2 = [
			"icon"        => "default_menu_icon",
			"page_icon"   => "default_page_icon",
			"text"        => 'Loc::getMessage("'.$amp2->lang_key.'_TEXT")',
			"title"       => 'Loc::getMessage("'.$amp2->lang_key.'_TITLE")',
			"parent_menu" => "global_menu_services",
			"url"         => $this->module->class_name."_ert.php",
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
	}

	/** @test */
	function it_creates_file_in_admin_folder(){
        $amp = $this->createAdminPageOnForm($this->module, [
            'name'        => 'Ololo',
            'code'        => 'trololo',
            "sort"        => "334",
            "text"        => "item",
            "parent_menu" => "global_menu_settings",
            "php_code"    => '<a href="test">test</a>',
            "lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
        ]);

        $pageContent = $this->disk()->get($this->module->module_folder.'/admin/'.$this->module->class_name."_trololo.php");
        $pageLangContent = $this->disk()->get($this->module->module_folder.'/lang/ru/admin/'.$this->module->class_name."_trololo.php");

        $this->assertEquals('<a href="test">test</a>', $pageContent);
        $this->assertEquals('<? $MESS["TEST"] = "test"; ?>', $pageLangContent);
    }
    /** @test */
    function it_creates_admin_file_is_never_empty_folder(){
        $amp = $this->createAdminPageOnForm($this->module, [
            'name'        => 'Ololo',
            'code'        => 'trololo',
            "sort"        => "334",
            "text"        => "item",
            "parent_menu" => "global_menu_settings",
            "php_code"    => '',
            "lang_code"   => ''
        ]);

        $pageContent = $this->disk()->get($this->module->module_folder.'/admin/'.$this->module->class_name."_trololo.php");
        $pageLangContent = $this->disk()->get($this->module->module_folder.'/lang/ru/admin/'.$this->module->class_name."_trololo.php");

        $this->assertEquals('<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $USER, $APPLICATION, $DB;

$APPLICATION->SetTitle(Loc::getMessage("TITLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); ?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php"); ?>', $pageContent);
        $this->assertEquals('<?
$MESS["TITLE"] = "Ololo";', trim($pageLangContent));
    }

	/** @test */
	function it_remove_admin_folder_if_there_is_no_more_pages(){
		$amp = $this->createAdminPageOnForm($this->module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$this->removeAdminPage($this->module, $amp);

		$this->assertFalse(file_exists($this->module->getFolder(true).'/admin/'.$this->module->class_name."_trololo.php"));
		$this->assertFalse(file_exists($this->module->getFolder(true).'/admin/menu.php'));
		$this->assertFalse(file_exists($this->module->getFolder(true).'/lang/ru/admin/'.$this->module->class_name."_trololo.php"));
	}
}

?>