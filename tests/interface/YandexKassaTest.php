<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class YandexKassaTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function check_url_test(){
		$action = 'checkOrder';
		$orderSumAmount = 1;
		$orderSumCurrencyPaycash = 1;
		$orderSumBankPaycash = 1;
		$invoiceId = 1;
		$customerNumber = 1;
		$shopId = env('YANDEX_KASSA_SHOP_ID');
		$scid = env('YANDEX_KASSA_SHOP_PASSWORD');
		$hash = md5($action.';'.$orderSumAmount.';'.$orderSumCurrencyPaycash.';'.$orderSumBankPaycash.';'.$shopId.';'.$invoiceId.';'.$customerNumber.';'.$scid);

		$response = $this->call(
			'GET',
			'/yandex_kassa/check_order/',
			[
				'action'                  => $action,
				'shopId'                  => $shopId,
				'orderSumAmount'          => $orderSumAmount,
				'orderSumCurrencyPaycash' => $orderSumCurrencyPaycash,
				'orderSumBankPaycash'     => $orderSumBankPaycash,
				'invoiceId'               => $invoiceId,
				'customerNumber'          => $customerNumber,
				'scid'                    => $scid,
				'md5'                     => $hash,
			]
		);

		$this->assertResponseStatus(200);
		$this->assertNotFalse(strpos($response->content(), 'code="0"'));
	}

	/** @test */
	function check_url_wrong_params_test(){
		$action = 'checkOrder';
		$orderSumAmount = 1;
		$orderSumCurrencyPaycash = 1;
		$orderSumBankPaycash = 1;
		$invoiceId = 1;
		$customerNumber = 1;
		$shopId = 'ololo';
		$scid = 'trololo';
		$hash = md5($action.';'.$orderSumAmount.';'.$orderSumCurrencyPaycash.';'.$orderSumBankPaycash.';'.$shopId.';'.$invoiceId.';'.$customerNumber.';'.$scid);

		$response = $this->call(
			'GET',
			'/yandex_kassa/check_order/',
			[
				'action'                  => $action,
				'shopId'                  => $shopId,
				'orderSumAmount'          => $orderSumAmount,
				'orderSumCurrencyPaycash' => $orderSumCurrencyPaycash,
				'orderSumBankPaycash'     => $orderSumBankPaycash,
				'invoiceId'               => $invoiceId,
				'customerNumber'          => $customerNumber,
				'scid'                    => $scid,
				'md5'                     => $hash,
			]
		);

		$this->assertResponseStatus(200);
		$this->assertNotFalse(strpos($response->content(), 'code="1"'));
	}

	/** @test */
	function payment_aviso_url_test(){
		// чтобы был пользователь
		factory(App\Models\User::class)->create([
			'email'    => 'ololo@test.ru',
			'password' => bcrypt("12345678"),
		]);

		$user = User::where('email', 'ololo@test.ru')->first();

		$action = 'paymentAviso';
		$orderSumAmount = setting('day_price');
		$orderSumCurrencyPaycash = 1;
		$orderSumBankPaycash = 1;
		$invoiceId = 1;
		$customerNumber = $user->id;
		$shopId = env('YANDEX_KASSA_SHOP_ID');
		$scid = env('YANDEX_KASSA_SHOP_PASSWORD');
		$hash = md5($action.';'.$orderSumAmount.';'.$orderSumCurrencyPaycash.';'.$orderSumBankPaycash.';'.$shopId.';'.$invoiceId.';'.$customerNumber.';'.$scid);

		$response = $this->call(
			'GET',
			'/yandex_kassa/payment_aviso/',
			[
				'action'                  => $action,
				'shopId'                  => $shopId,
				'orderSumAmount'          => $orderSumAmount,
				'orderSumCurrencyPaycash' => $orderSumCurrencyPaycash,
				'orderSumBankPaycash'     => $orderSumBankPaycash,
				'invoiceId'               => $invoiceId,
				'customerNumber'          => $customerNumber,
				'scid'                    => $scid,
				'md5'                     => $hash,
			]
		);

		$user = User::where('email', 'ololo@test.ru')->first(); // снова берём, чтобы получить актуальные данные

		$this->assertResponseStatus(200);
		$this->assertNotFalse(strpos($response->content(), 'code="0"'));
		$this->assertEquals(1, $user->paid_days);
	}
}

?>