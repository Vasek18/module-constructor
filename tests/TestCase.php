<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;

class TestCase extends Illuminate\Foundation\Testing\TestCase{
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://localhost';
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

	public function useBitrixStoreMethod(){
		// удаляем папку рыбного модуля
		$dirs = Storage::disk('user_modules')->directories();

		if (in_array("ololosha.test", $dirs)){
			Storage::disk('user_modules')->deleteDirectory("ololosha.test");
		}

		$request = new Request();
		$request->MODULE_NAME = "Test";
		$request->MODULE_DESCRIPTION = "Ololo trololo";
		$request->MODULE_CODE = "test";
		$request->PARTNER_NAME = "Ololosha";
		$request->PARTNER_URI = "http://ololo.com";
		$request->PARTNER_CODE = "ololosha";

		$id = Bitrix::store($request);
		if (!$id){
			return false;
		}

		return Bitrix::find($id);

	}

	protected function disk(){
		return Storage::disk('user_modules_bitrix');
	}
}
