<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

/** @group bitrix_interface */
class BitrixCreateFormInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->visit('/my-bitrix/create');
		$this->seePageIs(route('login'));
	}

	/** @test */
	function it_substitute_user_data(){
		$this->signIn();

		$this->visit('/my-bitrix/create')
			->see($this->user->bitrix_company_name)
			->see($this->user->site)
			->see($this->user->bitrix_partner_code);
	}

	/** @test */
	function it_returns_error_request_without_partner_name(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Имя партнёра" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_partner_uri(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_URI' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Ссылка на ваш сайт" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_partner_code(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_CODE' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Код партнёра" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_module_name(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Название модуля" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_module_code(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_CODE' => '']);

		$this->deleteFolder('');

		$this->see('Поле "Код модуля" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_module_version(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_VERSION' => '']);

		$this->deleteFolder('');

		$this->see('Поле "Версия модуля" обязательно');
	}

	/** @test */
	function it_returns_error_request_without_partner_name_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Partner name" field is required');
	}

	/** @test */
	function it_returns_error_request_without_partner_uri_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_URI' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Partner uri" field is required');
	}

	/** @test */
	function it_returns_error_request_without_partner_code_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_CODE' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Partner code" field is required');
	}

	/** @test */
	function it_returns_error_request_without_module_name_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Module name" field is required');
	}

	/** @test */
	function it_returns_error_request_without_module_code_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_CODE' => '']);

		$this->deleteFolder('');

		$this->see('The "Module code" field is required');
	}

	/** @test */
	function it_returns_error_request_without_module_version_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_VERSION' => '']);

		$this->deleteFolder('');

		$this->see('The "Module version" field is required');
	}

	/** @test */
	function it_returns_an_error_when_a_pair_of_user_code_and_module_code_are_not_unique(){
		$this->signIn();

		$this->fillNewBitrixForm();
		$this->fillNewBitrixForm();

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Модуль с таким кодом уже существует у вас');
	}

	/** @test */
	function it_returns_an_error_when_a_pair_of_user_code_and_module_code_are_not_unique_en(){
		$this->setLang('en');
		$this->signIn();

		$this->fillNewBitrixForm();
		$this->fillNewBitrixForm();

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Module with such code already exists among yours');
	}

	/** @test */
	function it_returns_an_error_when_partner_code_is_not_unique(){
		$bitrix_partner_code = 'test';

		// кто-то создаёт модуль
		$this->signIn(null, ['bitrix_partner_code' => $bitrix_partner_code]);
		$module1 = $this->fillNewBitrixForm();

		// приходит другой парень
		$this->signIn(null, ['bitrix_partner_code' => '']);
		// и создаёт модуль с тем же кодом партнёра
		$module2 = $this->fillNewBitrixForm(['MODULE_CODE' => 'ololo', 'PARTNER_CODE' => $bitrix_partner_code]);

		if ($module1){
			$module1->deleteFolder();
		}
		if ($module2){
			$module2->deleteFolder();
		}

		$this->see('Такой код партнёра уже занят');
	}
}

?>