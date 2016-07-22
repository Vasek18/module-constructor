<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixDetailPageFilesTest extends TestCase{

	use DatabaseTransactions;

	private $module;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	/** @test */
	function it_can_delete_module(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('delete');

		$dirs = $this->disk()->directories();
		$this->assertFalse(in_array($this->module->PARTNER_CODE.'.'.$this->module->code, $dirs));
	}

	// /** @test */ // todo
	// function smn_can_download_zip(){
	// 	$this->visit('/my-bitrix/'.$this->module->id);
	// 	$this->module->generateZip('utf-8');
	// 	// $this->submitForm('module_download');
	// }
}

?>