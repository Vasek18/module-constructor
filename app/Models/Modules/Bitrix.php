<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Chumper\Zipper\Zipper;

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
	public static function store(Request $request){
		// проверка на уникальность пары код партнёра / код модуля // todo не работает
		//if (Bitrix::where('PARTNER_CODE', $request->PARTNER_CODE)->where('MODULE_CODE', $request->MODULE_CODE)->get()){
		//	return false; // todo выброс ошибки
		//}


		$user_id = Auth::user()->id;

		$bitrix = new Bitrix;

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
		$bitrix::completeUserProfile($user_id, $request);

		// создание папки модуля пользователя на серваке
		$bitrix::createFolder($request);

		// запись в БД
		$bitrix->MODULE_NAME = $request->MODULE_NAME;
		$bitrix->MODULE_DESCRIPTION = $request->MODULE_DESCRIPTION;
		$bitrix->MODULE_CODE = $request->MODULE_CODE;
		$bitrix->PARTNER_NAME = $request->PARTNER_NAME;
		$bitrix->PARTNER_URI = $request->PARTNER_URI;
		$bitrix->PARTNER_CODE = $request->PARTNER_CODE;
		$bitrix->VERSION = $request->MODULE_VERSION;
		$bitrix->user_id = $user_id;
		if ($bitrix->save()){
			return $bitrix->id;
		}

	}

	// создание папки с модулем на серваке
	// todo проверка защиты
	public static function createFolder(Request $request){
		$myModuleFolder = $request->PARTNER_CODE.".".$request->MODULE_CODE; // папка модуля // todo так можно скачать модуль, зная всего два эти параметра, а они открытые (Если вообще можно обращаться к этим папкам)
		$LANG_KEY = strtoupper($request->PARTNER_CODE."_".$request->MODULE_CODE);

		// берём файлы из шаблона
		$installIndexFile = Storage::disk('modules_templates')->get('bitrix/install/index.php'); // файл-точка_входа_установки
		$includeFile = Storage::disk('modules_templates')->get('bitrix/include.php'); // обязательный, но пока ненужный файл
		$versionFile = Storage::disk('modules_templates')->get('bitrix/install/version.php');
		$indexLangFile = Storage::disk('modules_templates')->get('bitrix/lang/ru/install/index.php');

		// воссоздаём начальную структуру
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/install");

		// подставляем значения в шаблон индексного файла
		$template_search = ['{MODULE_CLASS_NAME}', '{MODULE_ID}', '{LANG_KEY}'];
		$template_replace = [$request->PARTNER_CODE."_".$request->MODULE_CODE, $request->PARTNER_CODE.".".$request->MODULE_CODE, $LANG_KEY];
		$installIndexFile = str_replace($template_search, $template_replace, $installIndexFile);

		// подставляем значения в файл версии
		$template_search = ['{VERSION}', '{DATE_TIME}'];
		$template_replace = [$request->MODULE_VERSION, date('Y-m-d H:i:s')];
		$versionFile = str_replace($template_search, $template_replace, $versionFile);

		// работаем с лангами
		// воссоздаём начальную структуру
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/lang/ru/install");
		// подставляем значения в шаблон индексного файла
		$template_search = ['{LANG_KEY}', '{MODULE_NAME}', '{MODULE_DESCRIPTION}', '{PARTNER_NAME}', '{PARTNER_URI}'];
		$template_replace = [$LANG_KEY, $request->MODULE_NAME, $request->MODULE_DESCRIPTION, $request->PARTNER_NAME, $request->PARTNER_URI];
		$indexLangFile = str_replace($template_search, $template_replace, $indexLangFile);
		// .работаем с лангами

		// кладём файлы в пользовательский модуль
		Storage::disk('user_modules')->put($myModuleFolder."/install/index.php", $installIndexFile);
		Storage::disk('user_modules')->put($myModuleFolder."/include.php", $includeFile);
		Storage::disk('user_modules')->put($myModuleFolder."/install/version.php", $versionFile);
		Storage::disk('user_modules')->put($myModuleFolder."/lang/ru/install/index.php", $indexLangFile);
	}

	// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
	static private function completeUserProfile($user_id, Request $request){
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
	}

	// форматирование вида даты
	public function getUpdatedAtAttribute($date){
		return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
	}

	// создаёт архив модуля для скачивания
	// todo проверки на успех
	public static function generateZip($id){
		$module = Bitrix::find($id);
		$folder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		$archiveName = $module->PARTNER_CODE."_".$module->MODULE_CODE.".zip";
		$rootFolder = Storage::disk('user_modules')->getDriver()->getAdapter()->getPathPrefix();

		$zipper = new \Chumper\Zipper\Zipper;
		$zipper->make($archiveName)->add($rootFolder.$folder);
		return $archiveName;
	}
}
