<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_interface */
class BitrixDetailPageInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

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
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id);
		$this->seePageIs(route('login'));
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id);

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_displays_module_data(){
		$this->module->deleteFolder();
		$this->module = $this->fillNewBitrixForm([
			'MODULE_NAME'        => 'Supermodule',
			'MODULE_DESCRIPTION' => 'Awesome module',
			'MODULE_CODE'        => 'mysupermodule',
			'MODULE_VERSION'     => '0.0.4',
			'PARTNER_CODE'       => 'god',
		]);

		$this->visit('/my-bitrix/'.$this->module->id);
		$this->seePageIs('/my-bitrix/'.$this->module->id);
		$this->see('Supermodule');
		$this->see('Awesome module');
		$this->see('god.mysupermodule');
		$this->see('0.0.4');
	}

	/** @test */
	function it_can_delete_module(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('delete');
		$this->seePageIs('/personal');
	}

	// /** @test */ // поскольку в тестах у меня нет скачки, этот тест бессмысленный
	// function smn_can_download_zip(){
	// 	$this->visit('/my-bitrix/'.$this->module->id);
	// 	$this->submitForm('module_download');
	// 	$this->assertResponseOk();
	// }
}

?>