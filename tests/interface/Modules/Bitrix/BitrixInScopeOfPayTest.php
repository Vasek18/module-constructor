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
			'_token' => csrf_token(),
		));

		$this->assertEquals($response->getStatusCode(), 302); // 302 - перенаправление, так что тоже подходит

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
	}
}

?>