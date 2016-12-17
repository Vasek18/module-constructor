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
		Log::info('YK checkOrder '.$request->fullUrl());

		$code = $this->isValidHash($request);

		$response = $this->generateResponseContent($request, $code, 'checkOrderResponse');

		return response($response, 200, [
			'Content-type' => 'application/xml'
		]);
	}

	// перевод денег
	public function paymentAviso(Request $request){
		Log::info('YK paymentAviso '.$request->fullUrl());

		$code = $this->isValidHash($request);

		$response = $this->generateResponseContent($request, $code, 'paymentAvisoResponse');

		if ($request->customerNumber){
			// зачисление средств на счёт
			$user = User::find($request->customerNumber);
			$user->addRubles($request->orderSumAmount);
			$days = $user->convertRublesToDays();

			// записываем файкт оплаты
			Pays::create([
				'user_id' => $request->customerNumber,
				'amount'  => $request->orderSumAmount,
			]);

			// письмо мне
			Mail::send('emails.admin.user_paid', ['user' => $user, 'sum' => $request->orderSumAmount, 'days' => $days], function ($m){
				$m->to(env('GOD_EMAIL'))->subject('Произведена оплата');
			});
		}

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
		$hash = md5(htmlspecialchars($request->action).';'.htmlspecialchars($request->orderSumAmount).';'.htmlspecialchars($request->orderSumCurrencyPaycash).';'.htmlspecialchars($request->orderSumBankPaycash).';'.env('YANDEX_KASSA_SHOP_ID').';'.htmlspecialchars($request->invoiceId).';'.htmlspecialchars($request->customerNumber).';'.env('YANDEX_KASSA_SHOP_PASSWORD'));
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
