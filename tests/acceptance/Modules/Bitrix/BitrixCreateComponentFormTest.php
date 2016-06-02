<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use App\Models\Modules\Bitrix\BitrixComponent;

//class BitrixCreateComponentFormTest extends TestCase{
//
//	use DatabaseTransactions;
//
//	function fillNewComponentForm($params = Array()){
//		if (!isset($params['COMPONENT_NAME'])){
//			$params['COMPONENT_NAME'] = "Ololo";
//		}
//		if (!isset($params['COMPONENT_CODE'])){
//			$params['COMPONENT_CODE'] = "ololo";
//		}
//		//if (!isset($params['COMPONENT_ICON'])){
//		//	$params['COMPONENT_ICON'] = $this->user->bitrix_partner_code;
//		//}
//		if (!isset($params['COMPONENT_DESCRIPTION'])){
//			$params['COMPONENT_DESCRIPTION'] = 'Ololo trololo';
//		}
//		if (!isset($params['COMPONENT_SORT'])){
//			$params['COMPONENT_SORT'] = '100';
//		}
//		$this->type($params['COMPONENT_NAME'], 'COMPONENT_NAME');
//		$this->type($params['COMPONENT_CODE'], 'COMPONENT_CODE');
//		$this->type($params['COMPONENT_DESCRIPTION'], 'COMPONENT_DESCRIPTION');
//		//$this->type($params['COMPONENT_ICON'], 'COMPONENT_ICON');
//		$this->type($params['COMPONENT_SORT'], 'COMPONENT_SORT');
//		$this->press('create_component');
//	}
//
//	/** @test */
//	function smn_can_create_component(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$this->visit('/my-modules/bitrix/'.$module->id.'/new_components');
//		$this->fillNewComponentForm();
//
//		Bitrix::deleteFolder($module);
//
//		$this->seeInDatabase('bitrix_components', [
//			'module_id' => $module->id,
//			'name'      => 'Ololo',
//			'code'      => 'ololo',
//			'sort'      => '100'
//		]);
//
//		$component = BitrixComponent::where('code', 'ololo')->first();
//
//		$this->seePageIs('my-modules/bitrix/'.$module->id.'/components/'.$component->id.'');
//	}
//
//	/** @test */
//	function unauthorized_cannot_get_to_this_page(){
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
//
//		$this->visit('/my-modules/bitrix/'.$module->id.'/new_components');
//		$this->seePageIs('/personal/auth');
//	}
//
//	/** @test */
//	function another_user_cannot_get_here_if_doesnt_own_the_module(){
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
//
//		$this->signIn();
//
//		$this->visit('/my-modules/bitrix/'.$module->id.'/new_components');
//		$this->seePageIs('/');
//	}
//
//	//todo /** @test */
//	//function it_doesnt_create_component_without_name(){
//	//}
//
//	//todo /** @test */
//	//	function it_doesnt_create_component_without_code(){
//	//	}
//}


?>