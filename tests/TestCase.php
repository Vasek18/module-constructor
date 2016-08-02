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
		// $uri = '';
		// if ($lang == 'en'){
		// 	$uri = str_replace('http://', 'http://en.', $this->currentUri);
		// }
		// if ($lang == 'ru'){
		// 	$uri = str_replace('http://en.', 'http://', $this->currentUri);
		// }
		// $this->visit($uri);
		Illuminate\Support\Facades\Session::put('lang', $lang);
	}
}
