<?php

use App\Models\Pays;
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
		$clientRepository = new ClientRepository();
		$client = $clientRepository->createPersonalAccessClient(
			null, 'Test Personal Access Client', $this->baseUrl
		);
		DB::table('oauth_personal_access_clients')->insert([
			'client_id'  => $client->id,
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		$this->user = factory(User::class)->create();
		$token = $this->user->createToken('TestToken', $this->scopes)->accessToken;
		$this->headers['Accept'] = 'application/json';
		$this->headers['Authorization'] = 'Bearer '.$token;
	}

	/** @test */
	// todo не работает
	public function tokens_are_work(){
		$this->json('GET', '/api/user', [], $this->header);
	}
}

?>