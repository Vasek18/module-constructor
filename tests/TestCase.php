<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestCase extends Illuminate\Foundation\Testing\TestCase{
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://constructor.local';
	protected $user;

	public function tearDown(){
		// иначе ошибка количества подключений
		$this->beforeApplicationDestroyed(function(){
			DB::disconnect();
		});

		parent::tearDown();
	}

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication(){
		ini_set('memory_limit', '256M');

		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		return $app;
	}

	public function signIn($user = null, $params = []){
		if (!isset($params["payed_days"])){
			$params["payed_days"] = setting('demo_days', 2);
		}
		if (!$user){
			$user = factory(App\Models\User::class)->create($params);
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

	public function payDays($days){
		// почему-то оба работают в разных местах

		$user = User::find(Auth::id());
		$user->payed_days = intval($days);
		$user->save();

		$this->user->payed_days = intval($days);
	}
}
