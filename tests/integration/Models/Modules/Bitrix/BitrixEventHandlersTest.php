<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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

	/** @test */
	function it_writes_register_handlers_code(){
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

		$content = file_get_contents($dirName.'/install/index.php');

		$registerCode = '\Bitrix\Main\EventManager::getInstance()->registerEventHandler("main", "OnProlog", $this->MODULE_ID, \'\Ololosha\Test\EventHandlers\Ololo\', "Trololo");';

		$this->assertNotFalse(strpos($content, $registerCode));

		Bitrix::deleteFolder($module);
	}

	/** @test */
	function it_writes_unregister_handlers_code(){
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

		$content = file_get_contents($dirName.'/install/index.php');

		$registerCode = '\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler("main", "OnProlog", $this->MODULE_ID, \'\Ololosha\Test\EventHandlers\Ololo\', "Trololo");';

		$this->assertNotFalse(strpos($content, $registerCode));

		Bitrix::deleteFolder($module);
	}

	/** @test */
	function it_writes_different_functions_of_one_class_at_one_file(){
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

		$handler2 = BitrixEventsHandlers::store($module, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Ololo',
				"method"      => 'Bar',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$handler::saveEventsInFolder($module->id);

		$dirName = Bitrix::getFolder($module);

		$classFile = file_get_contents($dirName.'\\lib\\eventhandlers\\'.strtolower($handler->class).'.php');

		$this->assertNotFalse(strpos($classFile, 'static public function '.$handler->method));
		$this->assertNotFalse(strpos($classFile, 'static public function '.$handler2->method));

		Bitrix::deleteFolder($module);

	}

	/** @test */
	function it_writes_different_classes_in_different_files(){
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

		$handler2 = BitrixEventsHandlers::store($module, [
				"event"       => 'OnProlog',
				"from_module" => 'main',
				"class"       => 'Foo',
				"method"      => 'Bar',
				"php_code"    => 'echo "Hello World";'
			]
		);

		$handler::saveEventsInFolder($module->id);

		$dirName = Bitrix::getFolder($module);

		$this->assertFileExists($dirName.'\\lib\\eventhandlers\\'.strtolower($handler->class).'.php');
		$this->assertFileExists($dirName.'\\lib\\eventhandlers\\'.strtolower($handler2->class).'.php');

		Bitrix::deleteFolder($module);

	}
}