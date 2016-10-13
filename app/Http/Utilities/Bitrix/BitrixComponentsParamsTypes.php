<?php

namespace App\Http\Utilities\Bitrix;

class BitrixComponentsParamsTypes{

	public static $types = [
		'STRING'   => [
			'form_type' => 'STRING',
		],
		'LIST'     => [
			'form_type' => 'LIST',
		],
		'CHECKBOX' => [
			'form_type' => 'CHECKBOX',
		],
		'FILE'     => [
			'form_type' => 'FILE',
		],
	];

	public static function all(){
		return static::$types;
	}
}