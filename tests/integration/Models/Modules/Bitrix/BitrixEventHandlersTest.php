<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class BitrixEventHandlersTest extends TestCase{

	use DatabaseTransactions;


	/** @test */
	function it_can_create_handler(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store([
				"module_id"   => $module->id,
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Ololo',
				"method"      => 'Trololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$this->seeInDatabase('bitrix_events_handlers', [
			"module_id"   => $module->id,
			"event"       => 'OnProlog',
			"from_module" => 'main',
			"class"       => 'Ololo',
			"method"      => 'Trololo',
			"php_code"    => 'echo "Hello World";'
		]);

	}

	//todo /** @test */
	//function it_doesnt_create_handler_with_the_lack_of_fields(){
	//
	//}
	//
	//todo /** @test */
	//function it_can_update_handler(){
	//
	//}
	//
	//todo /** @test */
	//function it_can_delete_handler(){
	//
	//}
	//
	//todo /** @test */
	//function it_creates_file_for_every_class(){
	//}
	//
	//todo /** @test */
	//function it_register_every_handler(){
	//}
	//
	//todo /** @test */
	//function it_writes_different_handlers_of_one_class_at_one_file(){
	//}
	//
	//todo /** @test */
	//function smn_cant_create_handlers_with_others_user_id(){
	//}
	//
	//todo /** @test */
	//function smn_cant_update_handlers_with_others_user_id(){
	//}
	//
	//todo /** @test */
	//function it_trims_fields(){
	//}

}