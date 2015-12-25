<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class Bitrix extends Model{
	//

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bitrixes';

	// на случай, если я где-то буду использовать create, эти поля можно будет записывать
	protected $fillable = ['MODULE_NAME', 'MODULE_DESCRIPTION', 'MODULE_CODE', 'PARTNER_NAME', 'PARTNER_URI', 'PARTNER_CODE'];

	// создание модуля
	public static function store(Request $request){
		$bitrix = new Bitrix;

		// запись в БД
		// todo валидация данных
		// todo user_id
		// todo наверное надо проверять на уникальность пару код партнёра / код модуля
		$bitrix->MODULE_NAME = $request->MODULE_NAME;
		$bitrix->MODULE_DESCRIPTION = $request->MODULE_DESCRIPTION;
		$bitrix->MODULE_CODE = $request->MODULE_CODE;
		$bitrix->PARTNER_NAME = $request->PARTNER_NAME;
		$bitrix->PARTNER_URI = $request->PARTNER_URI;
		$bitrix->PARTNER_CODE = $request->PARTNER_CODE;
		$bitrix->save();

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не указаны
		$user = User::find(Auth::user()->id); // имхо id можно и меньше кровью получить
		if (!$user->bitrix_partner_code){
			$user->bitrix_partner_code = $request->PARTNER_CODE;
		}
		if (!$user->bitrix_company_name){
			$user->bitrix_company_name = $request->PARTNER_NAME;
		}
		if (!$user->site){
			$user->site = $request->PARTNER_URI;
		}
		$user->save();

	}
}
