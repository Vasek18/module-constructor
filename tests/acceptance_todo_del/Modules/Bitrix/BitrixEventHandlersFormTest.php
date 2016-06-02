<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

//class BitrixEventHandlersFormTest extends TestCase{
//
//	use DatabaseTransactions;
//
//	function fillHandlerRowInForm($params = Array()){
//		if (!isset($params['from_module'])){
//			$params['from_module'] = "Main";
//		}
//		if (!isset($params['event'])){
//			$params['event'] = "OnProlog";
//		}
//		if (!isset($params['class'])){
//			$params['class'] = "Ololo";
//		}
//		if (!isset($params['method'])){
//			$params['method'] = 'Trololo';
//		}
//		$this->type($params['from_module'], 'from_module[]');
//		$this->type($params['event'], 'event[]');
//		$this->type($params['class'], 'class[]');
//		$this->type($params['method'], 'method[]');
//		$this->press('save_handlers'); // todo тесты вот из-за этого не работают
//	}
//
//	/** @test */
//	function unauthorized_cannot_get_to_this_page(){
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
//		$this->visit('/my-modules/bitrix/'.$module->id.'/events_handlers');
//		$this->seePageIs('/personal/auth');
//	}
//
//	// todo /** @test */
//	//function smn_can_create_handler(){
//	//	$this->signIn();
//	//
//	//	$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//	//
//	//	$this->visit('/my-modules/bitrix/'.$module->id.'/events_handlers');
//	//
//	//	$this->fillHandlerRowInForm();
//	//
//	//	$this->seeInDatabase('bitrix_events_handlers', [
//	//		"module_id"   => $module->id,
//	//		"event"       => 'OnProlog',
//	//		"from_module" => 'Main',
//	//		"class"       => 'Ololo',
//	//		"method"      => 'Trololo',
//	//		"php_code"    => ''
//	//	]);
//	//}
//
////	todo /** @test */
////	function smn_can_delete_module(){
////	}
////
//	/** @test */
//	//function it_doesnt_creates_when_not_all_necessary_fields_in_a_row_are_filled(){
//	//	$this->signIn();
//	//
//	//	$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//	//
//	//	$this->visit('/my-modules/bitrix/'.$module->id.'/events_handlers');
//	//
//	//	$this->fillHandlerRowInForm();
//	//
//	//	$this->dontSeeInDatabase('bitrix_events_handlers', [
//	//		"module_id"   => $module->id,
//	//		"event"       => 'OnProlog',
//	//		"from_module" => 'main',
//	//		"class"       => 'Ololo',
//	//		"method"      => 'Trololo',
//	//		"php_code"    => ''
//	//	]);
//	//}
////	todo /** @test */
////function it_trims_fields(){
////}
//}