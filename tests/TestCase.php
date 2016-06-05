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

	public function setLang($lang = 'ru'){
		app()->setLocale($lang);
	}

	protected function disk(){
		return Storage::disk('user_modules_bitrix');
	}
}
