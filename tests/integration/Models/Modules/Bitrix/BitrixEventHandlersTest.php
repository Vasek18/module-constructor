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

	/** @test */
	function hackers_cant_use_other_user_module_id(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$handler = BitrixEventsHandlers::store($module2, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Ololo',
				"method"      => 'Trololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$this->dontSeeInDatabase('bitrix_events_handlers', [
			"module_id"   => $module2->id,
			"event"       => 'OnProlog',
			"from_module" => 'main',
			"class"       => 'Ololo',
			"method"      => 'Trololo',
			"php_code"    => 'echo "Hello World";'
		]);
	}

	/** @test */
	function it_creates_file_for_class(){
		$this->signIn();

		$module = $this->useBitrixStoreMethod();

		$handler = BitrixEventsHandlers::store($module, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Ololo',
				"method"      => 'Trololo',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$handler::saveEventsInFolder($module->id);

		$dirName = Bitrix::getFolder($module);

		$this->assertFileExists($dirName.'\\lib\\eventhandlers\\'.strtolower($handler->class).'.php');

		Bitrix::deleteFolder($module);
	}

	// todo /** @test */
	//function it_register_handlers(){
	//	$this->signIn();
	//
	//	$module = $this->useBitrixStoreMethod();
	//
	//	$handler = BitrixEventsHandlers::store($module, [
	//			"event"       => 'OnProlog',
	//			"from_module" => 'main',
	//			"class"       => 'Ololo',
	//			"method"      => 'Trololo',
	//			"php_code"    => 'echo "Hello World";'
	//		]
	//	);
	//
	//	$handler::saveEventsInFolder($module->id);
	//
	//	$dirName = Bitrix::getFolder($module);
	//
	//	$handlerFile = $this->disk()->get($dirName.'\\install\\index.php');
	//
	//	$registerCode = '\Bitrix\Main\EventManager::getInstance()->registerEventHandler("main", "OnProlog", $this->MODULE_ID, "\Ololosha\Test\EventHandlers\Ololo", "Trololo");';
	//
	//	$this->assertNotFalse(strpos($handlerFile, $registerCode));
	//
	//	Bitrix::deleteFolder($module);
	//}

	//todo /** @test */
	//function it_writes_different_handlers_of_one_class_at_one_file(){
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