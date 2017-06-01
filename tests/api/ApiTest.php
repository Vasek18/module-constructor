<?php

/**
 * Внимание! Был измененён файл C:\xampp\htdocs\constructor.local\vendor\laravel\passport\src\PassportServiceProvider.php
 * P100Y заменён на P1Y
 */

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
	public function you_can_auth_with_token(){
		$this->json('GET', '/api/user', [], $this->headers);
		$this->see($this->user->first_name);
	}

	/** @test */
	public function user_can_see_his_modules(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$this->json('GET', '/api/modules', [], $this->headers);

		$this->seeJsonEquals([
			[
				'name'         => $module->name,
				'description'  => $module->description,
				'code'         => $module->code,
				'partner_code' => $module->PARTNER_CODE,
			],
			[
				'name'         => $module2->name,
				'description'  => $module2->description,
				'code'         => $module2->code,
				'partner_code' => $module2->PARTNER_CODE,
			]
		]);
	}

	/** @test */
	public function with_modules_user_get_iblocks_n_components(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$component = factory(App\Models\Modules\Bitrix\BitrixComponent::class)->create(['module_id' => $module->id]);
		$iblock = factory(App\Models\Modules\Bitrix\BitrixInfoblocks::class)->create(['module_id' => $module->id]);

		$this->json('GET', '/api/modules', [], $this->headers);

		$this->seeJsonEquals([
			[
				'name'         => $module->name,
				'description'  => $module->description,
				'code'         => $module->code,
				'partner_code' => $module->PARTNER_CODE,
				'components'   => [
					[
						'name' => $component->name,
						'code' => $component->code,
					]
				],
				'iblocks'      => [
					[
						'name' => $iblock->name,
						'code' => $iblock->code,
					]
				]
			]
		]);
	}
}