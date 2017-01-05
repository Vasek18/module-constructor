<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class ProjectHelpBitrixEventsTest extends TestCase{

	use DatabaseTransactions;

	protected $path = '/project_help/bitrix/events';

	function setUp(){
		parent::setUp();

		$this->visit($this->path);
	}

	/** @test */
	function user_see_only_approved_events(){
		$this->create_approved_event();
		$this->create_unapproved_event();

		$this->visit($this->path); // типа перезагрузка

		$this->see('OnEpilog');
		$this->dontSee('OnProlog');
	}

	/** @test */
	function user_see_only_approved_modules(){
		$this->create_approved_module();
		$this->create_unapproved_module();

		$this->visit($this->path); // типа перезагрузка

		$this->see('goodModule');
		$this->dontSee('testModule');
	}

	/** @test */
	function user_can_offer_event(){
		$this->submitForm('offer', [
			'module'      => 'main', // из миграции
			'event'       => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
		]);

		// $this->see(trans('project_help.bitrix_events_add_confirmation'));

		$count = DB::table('bitrix_core_events')->where([
			'module_id'   => 1, // из миграции
			'code'        => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
			'approved'    => false,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function user_cannot_offer_existing_event(){
		$this->submitForm('offer', [
			'module'      => 'main', // из миграции
			'event'       => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
		]);

		$this->submitForm('offer', [
			'module'      => 'main', // из миграции
			'event'       => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
		]);

		$this->see('Такое событие уже существует');

		$count = DB::table('bitrix_core_events')->where([
			'module_id'   => 1, // из миграции
			'code'        => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
			'approved'    => false,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function offered_module_is_not_approved(){
		$this->submitForm('offer', [
			'module'      => 'testModule',
			'event'       => 'testEvent',
			'params'      => '$content',
			'description' => 'Полезное событие',
		]);

		// $this->see(trans('project_help.bitrix_events_add_confirmation'));

		$count = DB::table('bitrix_core_modules')->where([
			'code'     => 'testModule',
			'approved' => false,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function user_can_mark_event_as_bad(){
		$event = $this->create_approved_event();
		$this->visit($this->path); // типа перезагрузка

		$this->click('mark_as_bad'.$event->id);

		$count = DB::table('bitrix_core_events')->where([
			'code'     => 'OnEpilog',
			'approved' => true,
			'is_bad'   => true,
		])->count();

		$this->assertEquals(1, $count);
	}
}

?>