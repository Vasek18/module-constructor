<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;

class TestCase extends Illuminate\Foundation\Testing\TestCase{
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://constructor.local';
	protected $user;

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication(){
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		return $app;
	}

	public function signIn($user = null){
		if (!$user){
			$user = factory(App\Models\User::class)->create();
		}
		$this->user = $user;

		$this->actingAs($user);

		return $this;
	}

	public function logOut(){
		$this->visit('/auth/logout');

		return $this;
	}

	public function setLang($lang = 'ru'){
		app()->setLocale($lang);
	}

	protected function disk(){
		return Storage::disk('user_modules_bitrix');
	}

	protected $standartModuleName = 'Ololo';
	protected $standartModuleDescription = 'Ololo trololo';
	protected $standartModuleCode = 'ololo_from_test';
	protected $standartModuleVersion = '0.0.1';

	// главная форма Битрикса
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

		if ($params['PARTNER_CODE'] && $params['MODULE_CODE']){
			return Bitrix::where('PARTNER_CODE', $params['PARTNER_CODE'])->where('code', $params['MODULE_CODE'])->first();
		}
	}

	function deleteFolder($moduleCode){
		if (Bitrix::where('code', $moduleCode)->count()){
			$modules = Bitrix::where('code', $moduleCode)->get();
			foreach ($modules as $module){
				$module->deleteFolder();
			}
		}
	}
}
