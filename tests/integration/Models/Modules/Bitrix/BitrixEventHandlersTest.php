<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class BitrixEventHandlersTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function store_method_works(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store($module, [
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

	/** @test */
	function it_doesnt_create_handler_without_event_field(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store($module, [
				"from_module" => 'main',
				"class"       => 'Ololo',
				"method"      => 'Trololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$this->dontSeeInDatabase('bitrix_events_handlers', [
			"module_id"   => $module->id,
			"from_module" => 'main',
			"class"       => 'Ololo',
			"method"      => 'Trololo',
			"php_code"    => 'echo "Hello World";'
		]);
	}

	/** @test */
	function it_doesnt_create_handler_without_from_module_field(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store($module, [
				"event"    => 'OnProlog',
				"class"    => 'Ololo',
				"method"   => 'Trololo',
				"php_code" => 'echo "Hello World";'
			]
		);

		$this->dontSeeInDatabase('bitrix_events_handlers', [
			"module_id" => $module->id,
			"event"     => 'OnProlog',
			"class"     => 'Ololo',
			"method"    => 'Trololo',
			"php_code"  => 'echo "Hello World";'
		]);
	}

	/** @test */
	function it_doesnt_create_handler_without_class_field(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store($module, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"method"      => 'Trololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$this->dontSeeInDatabase('bitrix_events_handlers', [
			"module_id"   => $module->id,
			"event"       => 'OnProlog',
			"from_module" => 'main',
			"method"      => 'Trololo',
			"php_code"    => 'echo "Hello World";'
		]);
	}

	/** @test */
	function it_doesnt_create_handler_without_method_field(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$handler = BitrixEventsHandlers::store($module, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Ololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$this->dontSeeInDatabase('bitrix_events_handlers', [
			"module_id"   => $module->id,
			"event"       => 'OnProlog',
			"from_module" => 'main',
			"class"       => 'Ololo',
			"php_code"    => 'echo "Hello World";'
		]);
	}

	//todo /** @test */
	//function hackers_cant_use_others_module_id(){
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