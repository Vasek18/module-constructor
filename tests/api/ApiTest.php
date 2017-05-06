<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

class ApiTest extends TestCase{

	use DatabaseTransactions;

	protected $headers = [];
	protected $scopes = [];

	public function setUp(){
		parent::setUp();

		// создаём нового пользователя
		$user = factory(App\Models\User::class)->create();
		$this->user = $user;

		// что-то для самого функционала ключей
		$oauthClientID = DB::table('oauth_clients')->insertGetId([
			'name'                   => 'Modules Constructor Test',
			'secret'                 => str_random(40),
			'redirect'               => 'http://localhost',
			'personal_access_client' => 1,
			'revoked'                => false,
			'created_at'             => new DateTime,
			'updated_at'             => new DateTime,
		]);
		DB::table('oauth_personal_access_clients')->insert([
			'client_id'  => $oauthClientID,
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);

		// создаём пользотелю токен
		$token = $this->user->createToken($this->user->id.' Access Token')->accessToken; // создаём новый токен

		// устанавливаем заголовки для авторизации через api
		$this->headers['Accept'] = 'application/json';
		$this->headers['Authorization'] = 'Bearer '.$token;
	}

	/** @test */
	// todo не работает
	public function you_can_auth_with_token(){
		$this->json('GET', '/api/user', [], $this->headers);
		$this->see($this->user->first_name);
	}
}

?>