<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixTest extends TestCase{

	use DatabaseTransactions;

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

		$request = new Request();
		$request->MODULE_NAME = "Test";
		$request->MODULE_DESCRIPTION = "Ololo trololo";
		$request->MODULE_CODE = "test";
		$request->PARTNER_NAME = "Ololosha";
		$request->PARTNER_URI = "http://ololo.com";
		$request->PARTNER_CODE = "ololosha";

		$module_id = Bitrix::store($request);

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

		$request = new Request();
		$request->MODULE_NAME = "Test";
		$request->MODULE_DESCRIPTION = "Ololo trololo";
		$request->MODULE_CODE = "test_comp";
		$request->PARTNER_NAME = "Ololosha_comp";
		$request->PARTNER_URI = "http://ololo_comp.com";
		$request->PARTNER_CODE = "ololosha_comp";
		Bitrix::store($request);

		$creator = User::find($user->id);

		$this->assertEquals("Ololosha_comp", $creator->bitrix_company_name);
		$this->assertEquals("ololosha_comp", $creator->bitrix_partner_code);
		$this->assertEquals("http://ololo_comp.com", $creator->site);
	}
}

?>