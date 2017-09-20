<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_interface */
class BitrixUserFieldsInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/data_storage';

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
	function user_can_create_bitrix_user_field(){
		$uf = $this->createUserFieldOnForm($this->module, [
			"entity_id"           => "USER",
			"field_name"          => "UF_TEST",
			"edit_form_label[ru]" => "Test"
		]);

		$this->seeInField('entity_id', 'USER');
		$this->seeInField('field_name', 'UF_TEST');
		$this->seeInField('edit_form_label[ru]', 'Test');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/user_fields/'.$uf->id.'/edit');
	}

	/** @test */
	function user_can_edit_bitrix_user_field(){
		// создаём
		$uf = $this->createUserFieldOnForm($this->module);
		$this->seeInField('entity_id', 'USER');
		$this->seeInField('field_name', 'UF_TEST');
		$this->seeInField('edit_form_label[ru]', 'Test');

		// меняем
		$this->type('UF_OLOLO', 'field_name');
		$this->press('save');

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/user_fields/'.$uf->id.'/edit');
		$this->seeInField('field_name', 'UF_OLOLO');
	}

	/** @test */
	function user_can_delete_bitrix_user_field(){
		// создаём
		$uf = $this->createUserFieldOnForm($this->module);
		$this->seeInField('entity_id', 'USER');
		$this->seeInField('field_name', 'UF_TEST');
		$this->seeInField('edit_form_label[ru]', 'Test');

		// удаляем
		$this->visit(action('Modules\Bitrix\BitrixDataStorageController@index', [$this->module]));
		$this->click('delete_user_field_'.$uf->id);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage');
		$this->dontSee('UF_TEST');
	}
}
