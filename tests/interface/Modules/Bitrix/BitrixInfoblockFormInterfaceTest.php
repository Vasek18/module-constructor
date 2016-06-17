<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixInfoblocks;

class BitrixInfoblockFormInterfaceTest extends TestCase{

	use DatabaseTransactions;

	function createIblockOnForm($module, $params){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['NAME'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['CODE'] = $params['code'];
		}
		if (isset($params['sort'])){
			$inputs['SORT'] = $params['sort'];
		}

		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixInfoblocks::where('code', $params['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->see('Добавить инфоблок');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->see('Add infoblock');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->logOut();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_returns_iblock_data_after_save(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => 'Ololo',
			'code' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Ololo');
		$this->see('trololo');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => 'Ololo',
			'code' => ''
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Код" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => '',
			'code' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Название" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => 'Ololo',
			'code' => ''
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Code" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => '',
			'code' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Name" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}
}

?>