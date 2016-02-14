<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BitrixCreateRequest extends Request{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(){
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		// todo
		//уникальность пары код_партнёра.код_модуля
		//коды только латинские символы и цифры (не с первого символа)
		return [
			'PARTNER_NAME'   => 'required',
			'PARTNER_URI'    => 'required',
			'PARTNER_CODE'   => 'required',
			'MODULE_NAME'    => 'required',
			'MODULE_CODE'    => 'required',
			'MODULE_VERSION' => 'required'
		];
	}
}
