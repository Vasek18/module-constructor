<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class YandexKassaController extends Controller{

	// проверка возможности платежа
	public function checkOrder(Request $request){
		$code = $this->isValidHash($request);

		Log::info('YK checkOrder '.$request->fullUrl()." ".serialize($request->all())."\n\rcode=".$code);

		$response = $this->generateResponseContent($request, $code, 'checkOrderResponse');

		return response($response, 200, [
			'Content-type' => 'application/xml'
		]);
	}

	// перевод денег
	public function paymentAviso(Request $request){
		$code = $this->isValidHash($request);

		Log::info('YK paymentAviso '.$request->fullUrl()." ".serialize($request->all())."\n\rcode=".$code);

		$response = $this->generateResponseContent($request, $code, 'paymentAvisoResponse');

		$customerNumber = $request->customerNumber ?: '';
		$orderSumAmount = $request->orderSumAmount;

		$user = '';
		$days = 0;
		if ($customerNumber){
			$user = User::find($customerNumber);

			if (setting('day_price')){
				// зачисление средств на счёт
				$user->addRubles($orderSumAmount);
				$days = $user->convertRublesToDays();
			}
		}

		// записываем факт оплаты
		$pay = new Pays();
		if ($customerNumber){
			$pay->user_id = $customerNumber;
		}
		$pay->amount = $orderSumAmount;
		$pay->save();

		// письмо мне
		Mail::send('emails.admin.user_paid', ['user' => $user, 'sum' => $orderSumAmount, 'days' => $days], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Произведена оплата');
		});

		return response($response, 200, [
			'Content-type' => 'application/xml'
		]);
	}

	// возвращение пользователя после успешной оплаты
	public function success(Request $request){
		Log::info('YK success '.$request->fullUrl());

		flash()->overlay(trans('oplata.oplata_success_title'), trans('oplata.oplata_success_p'));

		return redirect(action('PersonalController@index'));
	}

	// возвращение пользователя после неуспешной оплаты
	public function fail(Request $request){
		Log::info('YK fail '.$request->fullUrl());

		flash()->overlay(trans('oplata.oplata_fail_title'), trans('oplata.oplata_fail_p'), 'error');

		return redirect(action('PersonalController@oplata'));
	}

	// проверка md5 суммы
	public function isValidHash(Request $request){
		$hash = md5(htmlspecialchars($request->action).';'.htmlspecialchars($request->orderSumAmount).';'.htmlspecialchars($request->orderSumCurrencyPaycash).';'.htmlspecialchars($request->orderSumBankPaycash).';'.env('YANDEX_KASSA_SHOP_ID').';'.htmlspecialchars($request->invoiceId).';'.($request->customerNumber ? htmlspecialchars($request->customerNumber).';' : ';').env('YANDEX_KASSA_SHOP_PASSWORD'));
		if (strtolower($hash) != strtolower($request->md5)){
			return 1;
		}else{
			return 0;
		}
	}

	// генерация xml содержимого
	public function generateResponseContent(Request $request, $code, $tagName){
		return '<?xml version="1.0" encoding="UTF-8"?>
		<'.$tagName.' performedDatetime="'.htmlspecialchars($request->requestDatetime).'" code="'.$code.'"'.' invoiceId="'.htmlspecialchars($request->invoiceId).'" shopId="'.env('YANDEX_KASSA_SHOP_ID').'"/>';
	}
}
