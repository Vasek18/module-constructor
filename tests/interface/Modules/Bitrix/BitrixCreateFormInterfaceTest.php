<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class BitrixCreateFormInterfaceTest extends TestCase{

	use DatabaseTransactions;

	protected $standartModuleName = 'Ololo';
	protected $standartModuleDescription = 'Ololo trololo';
	protected $standartModuleCode = 'ololo_from_test';
	protected $standartModuleVersion = '0.0.1';

	function fillNewBitrixForm($params = Array()){
		if (!isset($params['PARTNER_NAME'])){
			$params['PARTNER_NAME'] = $this->user->bitrix_company_name;
		}
		if (!isset($params['PARTNER_URI'])){
			$params['PARTNER_URI'] = $this->user->site;
		}
		if (!isset($params['PARTNER_CODE'])){
			$params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
		}
		if (!isset($params['MODULE_NAME'])){
			$params['MODULE_NAME'] = $this->standartModuleName;
		}
		if (!isset($params['MODULE_DESCRIPTION'])){
			$params['MODULE_DESCRIPTION'] = $this->standartModuleDescription;
		}
		if (!isset($params['MODULE_CODE'])){
			$params['MODULE_CODE'] = $this->standartModuleCode;
		}
		if (!isset($params['MODULE_VERSION'])){
			$params['MODULE_VERSION'] = $this->standartModuleVersion;
		}

		$this->visit('/my-bitrix/create');

		$this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
		$this->type($params['PARTNER_URI'], 'PARTNER_URI');
		$this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
		$this->type($params['MODULE_NAME'], 'MODULE_NAME');
		$this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
		$this->type($params['MODULE_CODE'], 'MODULE_CODE');
		$this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
		$this->press('module_create');
	}

	function deleteFolder($moduleCode){
		if (Bitrix::where('code', $moduleCode)->count()){
			$module = Bitrix::where('code', $moduleCode)->first();
			$module->deleteFolder();
		}
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->visit('/my-bitrix/create');
		$this->seePageIs('/personal/auth');
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
}

?>