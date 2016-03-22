<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixTest extends TestCase{

	use DatabaseTransactions;

	protected function disk(){
		return Storage::disk('user_modules');
	}

	protected function useStoreMethod(){

		$request = new Request();
		$request->MODULE_NAME = "Test";
		$request->MODULE_DESCRIPTION = "Ololo trololo";
		$request->MODULE_CODE = "test";
		$request->PARTNER_NAME = "Ololosha";
		$request->PARTNER_URI = "http://ololo.com";
		$request->PARTNER_CODE = "ololosha";

		$id = Bitrix::store($request);
		if (!$id){
			return false;
		}

		return Bitrix::find($id);

	}

	/** @test */
	function it_can_upgrade_version_of_module(){
		$bitrix = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		Bitrix::upgradeVersion($bitrix->id, "0.0.2");

		$module = Bitrix::find($bitrix->id);

		Bitrix::deleteFolder($module);

		$this->assertEquals("0.0.2", $module->VERSION);
	}

	/** @test */
	function it_can_create_module(){
		$this->signIn();

		$module = $this->useStoreMethod();

		Bitrix::deleteFolder($module);

		$this->assertEquals("Test", $module->MODULE_NAME);
		$this->assertEquals("Ololo trololo", $module->MODULE_DESCRIPTION);
		$this->assertEquals("test", $module->MODULE_CODE);
		$this->assertEquals("Ololosha", $module->PARTNER_NAME);
		$this->assertEquals("http://ololo.com", $module->PARTNER_URI);
		$this->assertEquals("ololosha", $module->PARTNER_CODE);
		$this->assertEquals($this->user->id, $module->user_id);
	}

	/** @test */
	function it_completes_user_profile(){
		$user = factory(App\Models\User::class)->create(['bitrix_company_name' => null, 'bitrix_partner_code' => null, 'site' => null]);
		$this->actingAs($user);

		$module = $this->useStoreMethod();

		$creator = User::find($user->id);

		Bitrix::deleteFolder($module);

		$this->assertEquals("Ololosha", $creator->bitrix_company_name);
		$this->assertEquals("ololosha", $creator->bitrix_partner_code);
		$this->assertEquals("http://ololo.com", $creator->site);
	}

	/** @test */
	function it_can_update_download_count(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
		$oldCount = $module->download_counter;

		Bitrix::updateDownloadCount($module->id);

		$updatedModule = Bitrix::find($module->id);

		Bitrix::deleteFolder($module);

		$this->assertEquals($oldCount + 1, $updatedModule->download_counter);
	}

	/** @test */
	function it_creates_folder_for_module(){
		$this->signIn();

		$module = $this->useStoreMethod();

		$dirs = $this->disk()->directories();

		Bitrix::deleteFolder($module);

		$this->assertTrue(in_array("ololosha.test", $dirs));
	}

	/** @test */
	function it_returns_its_fullpath_from_method_getFolder(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$rootFolder = $this->disk()->getDriver()->getAdapter()->getPathPrefix();

		$folder = Bitrix::getFolder($module);

		Bitrix::deleteFolder($module);

		$this->assertEquals($rootFolder.$module->PARTNER_CODE.".".$module->MODULE_CODE, $folder);
	}

	/** @test */
	function unauthorized_user_cannot_create_module(){
		$this->useStoreMethod();

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "test",
			'PARTNER_CODE' => "ololosha"
		]);
	}

	/** @test */
	function it_fills_folder_with_necessary_files_at_creation(){
		$this->signIn();

		$module = $this->useStoreMethod();

		$dirName = Bitrix::getFolder($module);

		$this->assertFileExists($dirName.'/install/index.php');
		$this->assertFileExists($dirName.'/install/step.php');
		$this->assertFileExists($dirName.'/install/unstep.php');
		$this->assertFileExists($dirName.'/install/version.php');
		$this->assertFileExists($dirName.'/include.php');
		$this->assertFileExists($dirName.'/lang/ru/install/index.php');

		Bitrix::deleteFolder($module);
	}

	/** @test */
	function it_fills_right_lang_file_at_creation(){
		$this->signIn();

		$module = $this->useStoreMethod();
		$dirName = Bitrix::getFolder($module, false);
		$langFileContent = $this->disk()->get($dirName.'/lang/ru/install/index.php');

		$template_search = ['{MODULE_CLASS_NAME}', '{MODULE_ID}', '{LANG_KEY}', '{VERSION}', '{DATE_TIME}', '{MODULE_NAME}', '{MODULE_DESCRIPTION}', '{PARTNER_NAME}', '{PARTNER_URI}'];

		$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);
		$template_replace = [$module->PARTNER_CODE."_".$module->MODULE_CODE, $module->PARTNER_CODE.".".$module->MODULE_CODE, $LANG_KEY, $module->VERSION, date('Y-m-d H:i:s'), $module->MODULE_NAME, $module->MODULE_DESCRIPTION, $module->PARTNER_NAME, $module->PARTNER_URI];

		$templateLangFile = Storage::disk('modules_templates')->get('bitrix/lang/ru/install/index.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateLangFile);

		Bitrix::deleteFolder($module);

		$this->assertEquals($expectedContent, $langFileContent);
	}

	/** @test */
	function it_fills_right_version_file_at_creation(){
		$this->signIn();

		$module = $this->useStoreMethod();
		$dirName = Bitrix::getFolder($module, false);
		$langFileContent = $this->disk()->get($dirName.'/install/version.php');

		$template_search = ['{VERSION}', '{DATE_TIME}'];

		$template_replace = [$module->VERSION, $module->updated_at];

		$templateLangFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$expectedContent = $file = str_replace($template_search, $template_replace, $templateLangFile);

		Bitrix::deleteFolder($module);

		$this->assertEquals($expectedContent, $langFileContent);
	}

	/** @test */
	function it_returns_archive_name_for_download(){
		$this->signIn();
		$module = $this->useStoreMethod();

		$archiveName = Bitrix::generateZip($module);

		Bitrix::deleteFolder($module);

		$this->assertEquals($module->PARTNER_CODE."_".$module->MODULE_CODE.".zip", $archiveName);
	}

	/** @test */
	function it_generates_zip_archive(){
		$this->signIn();
		$module = $this->useStoreMethod();

		$archiveName = Bitrix::generateZip($module);

		Bitrix::deleteFolder($module);

		$this->assertFileExists($module->PARTNER_CODE."_".$module->MODULE_CODE.".zip");
	}

	/** @test */
	function it_doesnt_rewrite_existing_folder_with_the_same_name(){
		$this->signIn();
		$module = $this->useStoreMethod();
		$this->assertFalse($this->useStoreMethod());

		Bitrix::deleteFolder($module);

	}

	/** @test */
	function it_can_change_name_in_files(){
		$this->signIn();
		$module = $this->useStoreMethod();
		$dirName = Bitrix::getFolder($module, false);

		$module->MODULE_NAME = "Ololo Trololo New";
		$module->save();
		$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);

		$langFile = $this->disk()->get($dirName.'/lang/ru/install/index.php');

		Bitrix::deleteFolder($module);
		$this->assertTrue(!!strpos($langFile, '$MESS["OLOLOSHA_TEST_MODULE_NAME"] = "Ololo Trololo New";'));
	}

	/** @test */
	function it_can_change_description_in_files(){
		$this->signIn();
		$module = $this->useStoreMethod();
		$dirName = Bitrix::getFolder($module, false);

		$module->MODULE_DESCRIPTION = "Lorem ipsum";
		$module->save();
		$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);

		$langFile = $this->disk()->get($dirName.'/lang/ru/install/index.php');

		Bitrix::deleteFolder($module);
		$this->assertTrue(!!strpos($langFile, '$MESS["OLOLOSHA_TEST_MODULE_DESC"] = "Lorem ipsum";'));

	}

	/** @test */
	function pair_of_partner_code_and_module_code_always_unique(){
		$this->signIn();

		$module = $this->useStoreMethod();
		$this->useStoreMethod();

		$count = Bitrix::where('PARTNER_CODE', "ololosha")->where('MODULE_CODE', "test")->count();

		Bitrix::deleteFolder($module);

		$this->assertEquals(1, $count);
	}
}

?>