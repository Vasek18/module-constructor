<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group authreg */
class AuthenticationInterfaceTest extends TestCase{

	use DatabaseTransactions;

	function setUp(){
		parent::setUp();

		factory(App\Models\User::class)->create([
			'email'    => 'ololo@test.ru',
			'password' => bcrypt("12345678"),
		]);

		$this->visit('/login');
	}

	/** @test */
	function user_can_log_in(){
		$this->submitForm('login', [
			'email'    => 'ololo@test.ru',
			'password' => '12345678',
		]);

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_error_when_there_is_no_email_ru(){
		$this->submitForm('login', [
			'email'    => '',
			'password' => '12345678',
		]);

		$this->see('Поле "E-mail" обязательно');
	}

	/** @test */
	function it_returns_error_when_there_is_no_password_ru(){
		$this->submitForm('login', [
			'email'    => 'ololo@test.ru',
			'password' => '',
		]);

		$this->see('Поле "Пароль" обязательно');
	}

	/** @test */
	function it_returns_error_when_there_is_no_email_en(){
		$this->setLang('en');

		$this->submitForm('login', [
			'email'    => '',
			'password' => '12345678',
		]);

		$this->see('The email field is required');
	}

	/** @test */
	function it_returns_error_when_there_is_no_password_en(){
		$this->setLang('en');

		$this->submitForm('login', [
			'email'    => 'ololo@test.ru',
			'password' => '',
		]);

		$this->see('The password field is required');
	}

	/** @test */
	function it_returns_error_when_there_is_no_such_email_ru(){
		$this->submitForm('login', [
			'email'    => 'test@test.ru',
			'password' => '12345678',
		]);

		$this->see('Эти учетные данные не совпадают с нашими записями');
	}

	/** @test */
	function it_returns_error_when_there_is_no_such_email_en(){
		$this->setLang('en');

		$this->submitForm('login', [
			'email'    => 'test@test.ru',
			'password' => '12345678',
		]);

		$this->see('These credentials do not match our records');
	}

	/** @test */
	function it_returns_error_when_there_is_wrong_password_ru(){
		$this->submitForm('login', [
			'email'    => 'ololo@test.ru',
			'password' => '123456789',
		]);

		$this->see('Эти учетные данные не совпадают с нашими записями');
	}

	/** @test */
	function it_returns_error_when_there_is_wrong_password_en(){
		$this->setLang('en');

		$this->submitForm('login', [
			'email'    => 'ololo@test.ru',
			'password' => '123456789',
		]);

		$this->see('These credentials do not match our records');
	}
}

?>