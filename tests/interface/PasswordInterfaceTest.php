<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordInterfaceTest extends TestCase{

	use DatabaseTransactions;

	function setUp(){
		parent::setUp();

		factory(App\Models\User::class)->create([
			'email'    => 'ololo@test.ru',
			'password' => bcrypt("12345678"),
		]);

		$this->visit('/password/email');
	}

	/** @test */
	function it_returns_error_when_there_is_no_such_email_ru(){
		$this->submitForm('send', [
			'email' => 'test@test.ru',
		]);

		$this->see('Мы не можем найти пользователя с таким адресом электронной почты');
	}

	/** @test */
	function it_returns_error_when_there_is_no_such_email_en(){
		$this->setLang('en');

		$this->submitForm('send', [
			'email' => 'test@test.ru',
		]);

		$this->see('We can\'t find a user with that e-mail address');
	}

	// /** @test */ // todo
	// function it_sends_email(){
	// 	$mock = Mockery::mock('Swift_Mailer');
	// 	$this->app['mailer']->setSwiftMailer($mock);
	//
	// 	$mock->shouldReceive('send')->once()->andReturnUsing(function ($message){
	// 		$this->assertArrayhasKey('ololo@test.ru', $message->getTo());
	// 	});
	// 	$this->submitForm('send', [
	// 		'email' => 'ololo@test.ru',
	// 	]);
	// }
}

?>