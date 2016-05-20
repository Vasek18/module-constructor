<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BitrixCreateRequest extends FormRequest{
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
		//коды только латинские символы и цифры (не с первого символа)
		// человеческие сообщения об ошибках
		return [
			'PARTNER_NAME'   => 'required',
			'PARTNER_URI'    => 'required',
			'PARTNER_CODE'   => 'required',
			'MODULE_NAME'    => 'required',
			'MODULE_CODE'    => 'required|unique:bitrixes,code,NULL,id,PARTNER_CODE,'.$this->PARTNER_CODE,
			'MODULE_VERSION' => 'required'
		];
	}
}
