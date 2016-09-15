<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

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

		$this->module->deleteFolder();
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function this_is_definitely_page_about_mail_events(){
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

		$this->seePageIs('/personal/auth');
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');
	}
}

?>