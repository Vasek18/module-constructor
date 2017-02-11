<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

/** @group bitrix_interface */
class BitrixEventHandlersInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/events_handlers';
	public $file;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		if ($this->module){
			$this->module->deleteFolder();
		}
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function this_is_definitely_page_about_event_handlers(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Привязка к событиям');
	}

	// /** @test */
	// function this_is_definitely_page_about_mail_events_en(){
	// 	$this->setLang('en');
	//
	// 	$this->visit('/my-bitrix/'.$this->module->id.$this->path);
	//
	// 	$this->see('Mail events');
	// }

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs(route('login'));
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function user_see_only_approved_events_at_module_editing(){
		$this->create_approved_event();
		$this->create_unapproved_event();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('OnEpilog');
		$this->dontSee('OnProlog');
	}

	/** @test */
	function user_see_only_approved_modules_at_module_editing(){
		$this->create_approved_module();
		$this->create_unapproved_module();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('goodModule');
		$this->dontSee('testModule');
	}

	/** @test */
	function if_user_use_new_module_or_event_we_save_it(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'ololo',
			'event'       => 'trololo',
		]);

		$countModules = DB::table('bitrix_core_modules')->where([
			'code'     => 'ololo',
			'approved' => false,
		])->count();

		$this->assertEquals(1, $countModules);

		$countEvents = DB::table('bitrix_core_events')->where([
			'code'     => 'trololo',
			'approved' => false,
		])->count();

		$this->assertEquals(1, $countEvents);
	}
}

?>