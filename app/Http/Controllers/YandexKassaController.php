<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YandexKassaController extends Controller{

	public function checkOrder(Request $request){
		Log::info('YK checkOrder '.$request->fullUrl());

		$code = $this->isValidHash($request);

		$response = $this->generateResponseContent($request, $code);

		return response($response, 200, [
			'Content-type' => 'application/xml'
		]);
	}

	public function paymentAviso(Request $request){
		Log::info('YK paymentAviso '.$request->fullUrl());

		return 'paymentAviso';
	}

	public function success(Request $request){
		Log::info('YK success '.$request->fullUrl());

		return 'success';
	}

	public function fail(Request $request){
		Log::info('YK fail '.$request->fullUrl());

		return 'fail';
	}

	public function isValidHash(Request $request){
		$hash = md5(htmlspecialchars($request->action).';'.htmlspecialchars($request->orderSumAmount).';'.htmlspecialchars($request->orderSumCurrencyPaycash).';'.htmlspecialchars($request->orderSumBankPaycash).';'.env('YANDEX_KASSA_SHOP_ID').';'.htmlspecialchars($request->invoiceId).';'.htmlspecialchars($request->customerNumber).';'.env('YANDEX_KASSA_SHOP_PASSWORD'));
		if (strtolower($hash) != strtolower($request->md5)){
			return 1;
		}else{
			return 0;
		}
	}

	public function generateResponseContent(Request $request, $code){
		return '<?xml version="1.0" encoding="UTF-8"?>
		<checkOrderResponse performedDatetime="'.htmlspecialchars($request->requestDatetime).'" code="'.$code.'"'.' invoiceId="'.htmlspecialchars($request->invoiceId).'" shopId="'.env('YANDEX_KASSA_SHOP_ID').'"/>';
	}
}
