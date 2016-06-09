<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixAdminOptionsFormInterfaceTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function author_can_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/admin_options');

		$this->seePageIs('/my-bitrix/'.$module->id.'/admin_options');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_settings(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/admin_options');

		$this->see('Страница настроек');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_settings_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.'/admin_options');

		$this->see('Admin settings page');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->logOut();

		$this->visit('/my-bitrix/'.$module->id.'/admin_options');

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$module->id.'/admin_options');

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}
}

?>