<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;


// todo удаление
class BitrixAdminMenuInterfaceTest extends TestCase{

	use DatabaseTransactions;

	function createAdminPageOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/create');

		if (!isset($inputs['name'])){
			$inputs['name'] = 'Ololo';
		}
		if (!isset($inputs['code'])){
			$inputs['code'] = 'trololo';
		}
		if (!isset($inputs["sort"])){
			$inputs['sort'] = "334";
		}
		if (!isset($inputs["text"])){
			$inputs['text'] = "item";
		}
		if (!isset($inputs["parent_menu"])){
			$inputs['parent_menu'] = 'global_menu_settings';
		}

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixAdminMenuItems::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function removeAdminPage($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/');
		$this->click('delete_amp_'.$amp->id);
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/admin_menu');

		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/admin_menu');

		$this->see('Страницы административного меню');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/admin_menu');

		$this->see('Admin menu page');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->logOut();

		$this->visit('/my-bitrix/'.$module->id.'/admin_menu');

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$module->id.'/admin_menu');

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_returns_page_data_after_save(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			"sort"        => "334",
			"text"        => "item",
			"parent_menu" => "global_menu_settings",
			"php_code"    => '<a href="test">test</a>',
			"lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInField('name', 'Ololo');
		$this->seeInField('code', 'trololo');
		$this->seeInField("sort", "334");
		$this->seeInField("text", "item");
		$this->seeIsSelected("parent_menu", "global_menu_settings");
		$this->seeInField("php_code", '<a href="test">test</a>');
		$this->seeInField("lang_code", '<? $MESS["TEST"] = "test"; ?>');

		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu/'.$amp->id);
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name'        => 'Ololo',
			'code'        => '',
			"parent_menu" => "global_menu_settings",
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Код" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu/create');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name' => '',
			'code' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Название" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu/create');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name' => 'Ololo',
			'code' => ''
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Code" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu/create');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$amp = $this->createAdminPageOnForm($module, [
			'name' => '',
			'code' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Name" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_menu/create');
	}

	// /** @test */
	// function it_can_remove_admin_menu_page(){
	// 	$this->signIn();
	// 	$module = $this->fillNewBitrixForm();
	//
	// 	$amp = $this->createAdminPageOnForm($module);
	// 	$this->removeAdminPage($module, $amp);
	// 	$module->deleteFolder();
	//
	// 	$this->visit('/my-bitrix/'.$module->id.'/data_storage/')->dontSee('bitrix');
	// }
}

?>