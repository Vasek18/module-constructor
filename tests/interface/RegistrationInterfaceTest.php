<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;

class RegistrationInterfaceTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;

	function setUp(){
		parent::setUp();

		$this->visit('/personal/reg');
	}

	/** @test */
	function user_can_sign_up_n_immediately_log_in(){
		Mail::shouldReceive('send')->once();

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->seePageIs('/personal');
		$this->see('Аристов Вася');
	}

	/** @test */
	function it_returns_error_when_there_is_no_email_ru(){
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => '',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('Поле "E-mail" обязательно');
	}

	/** @test */
	function it_returns_error_when_there_is_no_email_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => '',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('The email field is required');
	}

	/** @test */
	function it_returns_error_when_there_is_no_password_ru(){
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '',
			'password_confirmation' => '12345678',
		]);

		$this->see('Поле "Пароль" обязательно');
	}

	/** @test */
	function it_returns_error_when_there_is_no_password_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '',
			'password_confirmation' => '12345678',
		]);

		$this->see('The password field is required');
	}

	/** @test */
	function it_returns_error_when_there_is_no_first_name_ru(){
		$this->submitForm('signup', [
			'first_name'            => '',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('Поле "Имя" обязательно');
	}

	/** @test */
	function it_returns_error_when_there_is_no_first_name_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => '',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('The first name field is required');
	}

	/** @test */
	function it_returns_error_when_the_email_is_already_taken_ru(){
		factory(App\Models\User::class)->create([
			'email'    => 'ololo@test.ru',
			'password' => bcrypt("12345678"),
		]);

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('Такой почтовый адрес уже занят');
	}

	/** @test */
	function it_returns_error_when_the_email_is_already_taken_en(){
		$this->setLang('en');

		factory(App\Models\User::class)->create([
			'email'    => 'ololo@test.ru',
			'password' => bcrypt("12345678"),
		]);

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('The email has already been taken');
	}

	/** @test */
	function it_returns_error_when_the_password_is_too_short_ru(){
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345',
			'password_confirmation' => '12345',
		]);

		$this->see('Пароль должен быть не менее 6 символов в длину');
	}

	/** @test */
	function it_returns_error_when_the_password_is_too_short_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345',
			'password_confirmation' => '12345',
		]);

		$this->see('The password must be at least 6 characters');
	}

	/** @test */
	function it_returns_error_when_the_password_n_confirmation_do_not_match_short_ru(){
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '123456789',
		]);

		$this->see('Пароль и подтверждение не совпадают');
	}

	/** @test */
	function it_returns_error_when_the_password_n_confirmation_do_not_match_short_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '123456789',
		]);

		$this->see('The password confirmation does not match');
	}

	/** @test */
	function it_returns_error_when_the_email_is_not_valid_ru(){
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('Адрес почты не валидный');
	}

	/** @test */
	function it_returns_error_when_the_email_is_not_valid_en(){
		$this->setLang('en');

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->see('The email must be a valid email address');
	}

	/** @test */
	function it_gives_free_days(){
		Mail::shouldReceive('send')->once();

		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@test.ru',
			'paid_days' => setting('demo_days')
		]);
	}

	/** @test */
	function i_can_change_demo_days_count_at_settings_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);
		$this->visit('/oko/settings');
		$this->submitForm('save_demo_days', [
			'value' => '5',
		]);

		$this->logOut();

		Mail::shouldReceive('send')->once();

		$this->visit('/personal/reg');
		$this->submitForm('signup', [
			'first_name'            => 'Вася',
			'last_name'             => 'Аристов',
			'company_name'          => 'Aristov',
			'site'                  => 'http://aristov-vasiliy.ru/',
			'email'                 => 'ololo@test.ru',
			'password'              => '12345678',
			'password_confirmation' => '12345678',
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@test.ru',
			'paid_days' => 5
		]);
	}
}

?>