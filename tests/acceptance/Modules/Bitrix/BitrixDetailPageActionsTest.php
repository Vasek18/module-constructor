<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixDetailPageActionsTest extends TestCase{

	use DatabaseTransactions;

	protected $module;

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

	function createModuleLikeUser(){
		$this->visit('/construct/bitrix');

		if (!isset($params['PARTNER_NAME'])){
			$params['PARTNER_NAME'] = $this->user->bitrix_company_name;
		}
		if (!isset($params['PARTNER_URI'])){
			$params['PARTNER_URI'] = $this->user->site;
		}
		if (!isset($params['PARTNER_CODE'])){
			$params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
		}
		if (!isset($params['MODULE_NAME'])){
			$params['MODULE_NAME'] = 'Ololo';
		}
		if (!isset($params['MODULE_DESCRIPTION'])){
			$params['MODULE_DESCRIPTION'] = 'Ololo trololo';
		}
		if (!isset($params['MODULE_CODE'])){
			$params['MODULE_CODE'] = 'ololo';
		}
		if (!isset($params['MODULE_VERSION'])){
			$params['MODULE_VERSION'] = 'ololo';
		}
		$this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
		$this->type($params['PARTNER_URI'], 'PARTNER_URI');
		$this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
		$this->type($params['MODULE_NAME'], 'MODULE_NAME');
		$this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
		$this->type($params['MODULE_CODE'], 'MODULE_CODE');
		$this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
		$this->press('module_create');


		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			$this->module = $module;
		}
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$this->visit('/my-modules/bitrix/'.$module->id);
		$this->seePageIs('/personal/auth');
	}

	// todo /** @test */
	//function you_can_change_module_name_on_detail_page(){
	//
	//}
	//
	// todo /** @test */
	//function you_cant_get_another_user_module_detail_page(){
	//
	//}
	//
	// todo /** @test */
	//function you_can_change_module_description_on_detail_page(){
	//
	//}

	// todo /** @test */
	//function you_can_download_archive(){
	//	$this->signIn();
	//	$this->createModuleLikeUser();
	//	Bitrix::deleteFolder($this->module);
	//
	//	$this->press('Скачать');
	//}

	// todo /** @test */
	//function you_can_changeversion_before_download(){
	//
	//}
	//
	// todo /** @test */
	//function you_can_delete_module(){
	//
	//}
	//
	// todo /** @test */
	//function you_cant_delete_module_of_another_user(){
	//
	//}
	//
	// todo /** @test */
	//function you_cant_download_module_of_another_user(){
	//
	//}
	//
	// todo /** @test */
	//function you_cant_change_module_name_of_another_user(){
	//
	//}
	//
	// todo /** @test */
	//function you_cant_change_module_description_of_another_user(){
	//
	//}
}

?>