<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

	// создание модуля (записывание в бд)
	// todo валидация данных
	// todo проверять на уникальность пару код партнёра / код модуля
	public static function store(Request $request){
		$user_id = Auth::user()->id; // todo имхо id можно и меньше кровью получить

		$bitrix = new Bitrix;

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
		$user = User::find($user_id);
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

		// создание файлов модуля пользователя на серваке
		// берём индексный файл
		$installIndexFilePath = 'bitrix/install/index.php';
		$installIndexFile = Storage::disk('modules_templates')->get($installIndexFilePath);

		// воссоздаём начальную структуру
		$myModuleFolder = $request->PARTNER_CODE.".".$request->MODULE_CODE; // todo так можно скачать модуль, зная всего два эти параметра, а они открытые
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/install");
		// подставляем значения в шаблон
		$template_search = ['{MODULE_CLASS_NAME}', '{MODULE_ID}'];
		$template_replace= [$request->PARTNER_CODE."_".$request->MODULE_CODE, $request->PARTNER_CODE.".".$request->MODULE_CODE];
		$installIndexFile = str_replace($template_search, $template_replace, $installIndexFile);
		//dd($installIndexFile);
		// кладём в пользовательский модуль файл-точку_входа_установки
		Storage::disk('user_modules')->put($myModuleFolder."/install/index.php", $installIndexFile);

		// запись в БД
		$bitrix->MODULE_NAME = $request->MODULE_NAME;
		$bitrix->MODULE_DESCRIPTION = $request->MODULE_DESCRIPTION;
		$bitrix->MODULE_CODE = $request->MODULE_CODE;
		$bitrix->PARTNER_NAME = $request->PARTNER_NAME;
		$bitrix->PARTNER_URI = $request->PARTNER_URI;
		$bitrix->PARTNER_CODE = $request->PARTNER_CODE;
		$bitrix->user_id = $user_id;
		if ($bitrix->save()){
			return $bitrix->id;
		}

	}

	// форматирование вида даты
	public function getUpdatedAtAttribute($date){
		return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
	}
}
