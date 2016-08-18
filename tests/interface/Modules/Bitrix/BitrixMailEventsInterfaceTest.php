<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;

class BitrixMailEventsInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/mail_events';
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

		$this->see('Почтовые события');
	}

	/** @test */
	function this_is_definitely_page_about_mail_events_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Mail events');
	}

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

	/** @test */
	function it_returns_mail_event_data_on_detail_page(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path.'/'.$mail_event->id);
		$this->see('TestMail');
		$this->see('TEST_MAIL');
		$this->see('1808');
		$this->see('TROLOLO - Ololo');
	}
}

?>