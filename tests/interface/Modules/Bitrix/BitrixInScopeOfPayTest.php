<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixInScopeOfPayTest extends BitrixTestCase{

	use DatabaseTransactions;

	function setUp(){
		parent::setUp();

		$this->signIn();
	}

	function tearDown(){
		parent::tearDown();
	}

	/** @test */
	function free_user_can_create_module(){
		$this->module = $this->fillNewBitrixForm();

		$dirs = $this->disk()->directories();

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->user->bitrix_partner_code.'.ololo_from_test', $dirs));

		$this->module->deleteFolder();
	}

	/** @test */
	function free_user_cannot_download_module(){
		$this->module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$this->module->id);
		$this->dontSee('Скачать');

		$response = $this->call('POST', action('Modules\Bitrix\BitrixController@download_zip', $this->module->id), array(
			'_token' => csrf_token(),
		));
		$this->assertEquals($response->getStatusCode(), 403);

		$this->module->deleteFolder();
	}

	/** @test */
	function payed_user_can_download_module(){
		$this->module = $this->fillNewBitrixForm();
		$this->payDays(1);

		$this->visit('/my-bitrix/'.$this->module->id);
		$this->see('Скачать');

		$response = $this->call('POST', action('Modules\Bitrix\BitrixController@download_zip', $this->module->id), array(
			'_token'      => csrf_token(),
			'download_as' => 'fresh',
			'files'       => ['/include.php'],
		));

		$this->assertEquals(302, $response->getStatusCode()); // 302 - перенаправление, так что тоже подходит

		$this->module->deleteFolder();
	}

	/** @test */
	function free_user_dont_see_admin_options_files(){
		$this->module = $this->fillNewBitrixForm();
		$this->visit('/my-bitrix/'.$this->module->id.'/admin_options');
		$this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->dontSee($this->module->module_folder.'\options.php');
		$this->dontSee($this->module->module_folder.'\lang\ru\options.php');
		$this->see('Эту услугу нужно оплатить');

		$this->module->deleteFolder();
	}

	/** @test */
	function payed_user_see_admin_options_files(){
		$this->payDays(1);
		$this->module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$this->module->id.'/admin_options');
		$this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->see($this->module->module_folder.'\options.php');
		$this->see($this->module->module_folder.'\lang\ru\options.php');

		$this->module->deleteFolder();
	}

	/** @test */
	function free_user_cannot_download_component(){
		$this->module = $this->fillNewBitrixForm();

		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->dontSee('Скачать');

		$response = $this->call('GET', action('Modules\Bitrix\BitrixComponentsController@download', [$this->module->id, $component->id]), array(
			'_token' => csrf_token(),
		));
		$this->assertEquals($response->getStatusCode(), 403);

		$this->module->deleteFolder();
	}

	/** @test */
	function payed_user_can_download_component(){
		$this->module = $this->fillNewBitrixForm();
		$this->payDays(1);

		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->see('Скачать');

		$response = $this->call('GET', action('Modules\Bitrix\BitrixComponentsController@download', [$this->module->id, $component->id]), array(
			'_token' => csrf_token(),
		));
		$this->assertNotEquals($response->getStatusCode(), 403); // 302 - перенаправление, так что тоже подходит

		$this->module->deleteFolder();

		$pathToComponent = public_path().'/user_downloads/trololo.zip';
		unlink($pathToComponent); // иначе папка с архивом валяется
	}

	/** @test */
	function free_user_dont_see_component_params_files(){
		$this->module = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($this->module);
		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
		]);

		$this->dontSee($component->getFolder().'\.parameters.php');
		$this->dontSee($component->getFolder().'\lang\ru\.parameters.php');
		$this->see('Эту услугу нужно оплатить');

		$this->module->deleteFolder();
	}

	/** @test */
	function payed_user_see_component_params_files(){
		$this->payDays(1);
		$this->module = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($this->module);
		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
		]);

		$this->see($component->getFolder().'\.parameters.php');
		$this->see($component->getFolder().'\lang\ru\.parameters.php');

		$this->module->deleteFolder();
	}

	/** @test */
	function free_user_cannot_store_class_php(){
		$this->module = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->dontSee('name="class_php"');

		$this->module->deleteFolder();
	}

	/** @test */
	function payed_user_can_store_class_php(){
		$this->module = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($this->module);
		$this->payDays(1);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'class_php' => 'I\'m class',
		]);

		$class_php = $this->disk()->get($component->getFolder().'/class.php');

		$this->assertEquals('I\'m class', $class_php);

		$this->module->deleteFolder();
	}

	/** @test */
	function free_user_cannot_see_class_php_templates(){
		$this->module = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php/get_templates?items_list=items_list');

		$this->module->deleteFolder();

		$this->seePageIs('personal');
	}
}

?>