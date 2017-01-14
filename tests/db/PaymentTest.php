<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentTest extends BitrixTestCase{

	use DatabaseTransactions;

	/** @test */
	function it_gathers_payment(){
		$this->signIn(null, [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);
		$this->signIn(null, [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 1
		]);
		$this->signIn(null, [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 2
		]);

		$this->seeInDatabase('users', [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 1
		]);

		$this->seeInDatabase('users', [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 2
		]);

		// собираю оплату
		(new \App\Console\Commands\GatherPayment)->handle();

		$this->seeInDatabase('users', [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 0
		]);

		$this->seeInDatabase('users', [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 1
		]);
	}

	/** @test */
	function it_doesnt_gather_payment_when_service_is_free(){
		setSetting('day_price', 0); // цена сервиса

		$this->signIn(null, [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);
		$this->signIn(null, [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 1
		]);
		$this->signIn(null, [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 2
		]);

		$this->seeInDatabase('users', [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 1
		]);

		$this->seeInDatabase('users', [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 2
		]);

		// собираю оплату
		(new \App\Console\Commands\GatherPayment)->handle();

		$this->seeInDatabase('users', [
			'email'     => 'test@test.ru',
			'paid_days' => 0
		]);

		$this->seeInDatabase('users', [
			'email'     => 'ololo@ololo.ru',
			'paid_days' => 1
		]);

		$this->seeInDatabase('users', [
			'email'     => 'trololo@trololo.ru',
			'paid_days' => 2
		]);
	}
}

?>