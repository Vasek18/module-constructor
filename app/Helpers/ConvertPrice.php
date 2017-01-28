<?php

namespace App\Helpers;

class ConvertPrice{
	public $toRubRatio = [
		'rub' => 1,
		'usd' => 1 / 30,
	];

	public function getCurrentCurrency(){
		if (\App::isLocale('en')){
			return 'usd';
		}else{
			return 'rub';
		}
	}

	public function round($price){
		return ceil($price * 2) / 2; // округляем до 0,5
	}

	public function format($price){
		return number_format($price, 2, ',', ' ');
	}

	public function convert($price, $format = true){
		$toCurrency = $this->getCurrentCurrency();

		$price = $this->round($price * $this->toRubRatio[$toCurrency]);

		if ($format){
			return $this->format($price);
		}
		else{
			return $price;
		}
	}
}

?>