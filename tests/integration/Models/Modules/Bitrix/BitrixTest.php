<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixTest extends TestCase{

	use DatabaseTransactions;

	protected function useStoreMethod(){

		$request = new Request();
		$request->MODULE_NAME = "Test";
		$request->MODULE_DESCRIPTION = "Ololo trololo";
		$request->MODULE_CODE = "test";
		$request->PARTNER_NAME = "Ololosha";
		$request->PARTNER_URI = "http://ololo.com";
		$request->PARTNER_CODE = "ololosha";

		return Bitrix::store($request);

	}

	/** @test */
	function it_can_upgrade_version_of_module(){
		$bitrix = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		Bitrix::upgradeVersion($bitrix->id, "0.0.2");

		$module = Bitrix::find($bitrix->id);

		$this->assertEquals("0.0.2", $module->VERSION);
	}

	/** @test */
	function it_can_create_module(){
		$this->signIn();

		$module_id = $this->useStoreMethod();

		$module = Bitrix::find($module_id);

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

		$this->useStoreMethod();

		$creator = User::find($user->id);

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

		$this->assertEquals($oldCount+1, $updatedModule->download_counter);
	}

	/** @test */
	function it_creates_folder_for_module(){
		$this->signIn();

		$this->useStoreMethod();

		$dirs = Storage::disk('user_modules')->directories();

		$this->assertTrue(in_array("ololosha.test", $dirs));
	}

	/** @test */
	function it_returns_its_fullpath_from_method_getFolder(){
		$bitrix = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$rootFolder = Storage::disk('user_modules')->getDriver()->getAdapter()->getPathPrefix();

		$folder = Bitrix::getFolder($bitrix);

		$this->assertEquals($rootFolder.$bitrix->PARTNER_CODE.".".$bitrix->MODULE_CODE, $folder);
	}

	/** @test */
	function unauthorized_user_cannot_create_module(){
		$this->useStoreMethod();

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE' => "test",
			'PARTNER_CODE' => "ololosha"
		]);
	}
	//
	///** @test */
	//function it_fills_folder_right_at_creation(){
	//
	//}

	/** @test */
	function it_returns_archive_name_for_download(){
		$this->signIn();
		$module_id = $this->useStoreMethod();

		$bitrix = Bitrix::find($module_id);
		$archiveName = Bitrix::generateZip($bitrix);

		$this->assertEquals($bitrix->PARTNER_CODE."_".$bitrix->MODULE_CODE.".zip", $archiveName);
	}

	///** @test */
	//function it_generates_zip_archive(){
	//
	//}

	///** @test */
	//function it_doesnt_rewrite_existing_folder_with_the_same_name(){
	//
	//}

	///** @test */
	//function it_can_change_name_in_db_and_files(){
	//
	//}
	//
	///** @test */
	//function it_can_change_description_in_db_and_files(){
	//
	//}

	/** @test */
	function pair_of_partner_code_and_module_code_always_unique(){
		$this->signIn();

		$this->useStoreMethod();
		$this->useStoreMethod();

		$count = Bitrix::where('PARTNER_CODE', "ololosha")->where('MODULE_CODE', "test")->count();

		$this->assertEquals(1, $count);
	}




}

?>