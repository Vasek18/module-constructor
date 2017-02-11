<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_files */
class BitrixCreateFormFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

	function getModuleModel($code = null){
		if (!$code){
			$code = $this->standartModuleCode;
		}

		return Bitrix::where('code', $code)->first();
	}

	/** @test */
	function smn_can_create_module(){
		$this->signIn();

		$this->fillNewBitrixForm();

		$dirs = $this->disk()->directories();

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->user->bitrix_partner_code.'.ololo_from_test', $dirs));
	}

	/** @test */
	function it_fills_folder_with_necessary_files_at_creation(){
		$this->signIn();

		$this->fillNewBitrixForm();

		$module = $this->getModuleModel();

		$dirName = $module->getFolder();

		$this->assertFileExists($dirName.'/install/index.php');
		$this->assertFileExists($dirName.'/install/step.php');
		$this->assertFileExists($dirName.'/install/unstep.php');
		$this->assertFileExists($dirName.'/install/version.php');
		$this->assertFileExists($dirName.'/include.php');
		$this->assertFileExists($dirName.'/lang/ru/install/index.php');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_fills_right_lang_file_at_creation(){
		$this->signIn();

		$this->fillNewBitrixForm();

		$module = $this->getModuleModel();

		$langFileContent = $this->disk()->get($module->module_folder.'/lang/ru/install/index.php');

		$template_search = ['{MODULE_ID}', '{LANG_KEY}', '{MODULE_NAME}', '{MODULE_DESCRIPTION}', '{PARTNER_NAME}', '{PARTNER_URI}'];
		$template_replace = [$this->user->bitrix_partner_code.".".$this->standartModuleCode, $module->lang_key, $this->standartModuleName, $this->standartModuleDescription, $this->user->bitrix_company_name, $this->user->site];
		$templateLangFile = Storage::disk('modules_templates')->get('bitrix/lang/ru/install/index.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateLangFile);

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals($expectedContent, $langFileContent);
	}

	/** @test */
	function it_fills_right_version_file_at_creation(){
		$this->signIn();

		$module = $this->fillNewBitrixForm();

		$versionFileContent = $this->disk()->get($module->module_folder.'/install/version.php');

		$template_search = ['{VERSION}', '{DATE_TIME}'];
		$template_replace = [$this->standartModuleVersion, $module->updated_at];
		$templateVersionFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateVersionFile);

		$module->deleteFolder();

		$this->assertEquals($expectedContent, $versionFileContent);
	}

	/** @test */
	function it_doesnt_rewrite_existing_folder_with_the_same_name(){
		$this->signIn();
		$this->fillNewBitrixForm();

		$module = $this->getModuleModel();

		$versionFileContent = $this->disk()->get($module->module_folder.'/install/version.php');

		$this->fillNewBitrixForm();

		$module->deleteFolder();

		$this->assertNotFalse(strpos($versionFileContent, $module->updated_at.''), 'Module folder was rewrited');
	}

	/** @test */
	function it_trims_fields_in_lang_file(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_NAME'        => '  Test   ',
			'MODULE_DESCRIPTION' => '  Test   ',
			'MODULE_CODE'        => '  ololo_from_test   ',
			'PARTNER_NAME'       => '  Test   ',
			'PARTNER_URI'        => '  Test   ',
			'PARTNER_CODE'       => '  Test   ',
			'MODULE_VERSION'     => '  Test   '
		]);

		$module = $this->getModuleModel('ololo_from_test');
		$langFileContent = $this->disk()->get($module->module_folder.'/lang/ru/install/index.php');

		$template_search = ['{MODULE_ID}', '{LANG_KEY}', '{MODULE_NAME}', '{MODULE_DESCRIPTION}', '{PARTNER_NAME}', '{PARTNER_URI}'];
		$template_replace = ["Test.ololo_from_test", "TEST_OLOLO_FROM_TEST", 'Test', 'Test', 'Test', 'Test'];
		$templateLangFile = Storage::disk('modules_templates')->get('bitrix/lang/ru/install/index.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateLangFile);

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals($expectedContent, $langFileContent);
	}

	/** @test */
	function it_trims_version_value(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_VERSION' => '  0.0.1   ']);

		$module = $this->getModuleModel();

		$versionFileContent = $this->disk()->get($module->module_folder.'/install/version.php');

		$template_search = ['{VERSION}', '{DATE_TIME}'];
		$template_replace = ['0.0.1', $module->updated_at];
		$templateVersionFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateVersionFile);

		$module->deleteFolder();

		$this->assertEquals($expectedContent, $versionFileContent);
	}

	/** @test */
	function it_validates_version_field_from_nondigits(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_VERSION' => '  Test   '
		]);

		$module = $this->getModuleModel();

		$versionFileContent = $this->disk()->get($module->module_folder.'/install/version.php');

		$template_search = ['{VERSION}', '{DATE_TIME}'];
		$template_replace = ['0.0.1', $module->updated_at];
		$templateVersionFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateVersionFile);

		$module->deleteFolder();

		$this->assertEquals($expectedContent, $versionFileContent);
	}

	/** @test */
	function it_validates_version_field_from_all_zeros(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_VERSION' => '  0.0.0'
		]);

		$module = $this->getModuleModel();

		$versionFileContent = $this->disk()->get($module->module_folder.'/install/version.php');

		$template_search = ['{VERSION}', '{DATE_TIME}'];
		$template_replace = ['0.0.1', $module->updated_at];
		$templateVersionFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateVersionFile);

		$module->deleteFolder();

		$this->assertEquals($expectedContent, $versionFileContent);
	}
}

?>