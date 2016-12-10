<?php

namespace App\Http\Controllers;

class YandexKassaController extends Controller{
	public function checkOrder(){
		return 'checkOrder';
	}

	public function paymentAviso(){
		return 'paymentAviso';
	}

	public function success(){
		return 'success';
	}

	public function fail(){
		return 'fail';
	}
}
