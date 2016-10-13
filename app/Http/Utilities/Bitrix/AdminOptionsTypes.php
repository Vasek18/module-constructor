<?php

namespace App\Http\Utilities\Bitrix;

class AdminOptionsTypes{

	public static $options = [
		[
			'FORM_TYPE' => 'text',
		],
		[
			'FORM_TYPE' => 'textarea',
		],
		[
			'FORM_TYPE' => 'selectbox',
		],
		[
			'FORM_TYPE' => 'multiselectbox',
		],
		[
			'FORM_TYPE' => 'checkbox',
		],
		// [
		// 	'FORM_TYPE' => 'CUSTOM',
		// ],
	];

	public static function all(){
		return static::$options;
	}
}