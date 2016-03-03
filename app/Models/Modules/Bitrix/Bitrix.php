<?php

namespace App\Models\Modules\Bitrix;

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
	public static function store(Request $request){
		// проверка на уникальность пары код партнёра / код модуля // todo не работает
		//if (Bitrix::where('PARTNER_CODE', $request->PARTNER_CODE)->where('MODULE_CODE', $request->MODULE_CODE)->get()){
		//	return false; // todo выброс ошибки
		//}


		$user_id = Auth::user()->id;

		$bitrix = new Bitrix;

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
		$bitrix::completeUserProfile($user_id, $request);

		// запись в БД
		$bitrix->MODULE_NAME = $request->MODULE_NAME;
		$bitrix->MODULE_DESCRIPTION = $request->MODULE_DESCRIPTION;
		$bitrix->MODULE_CODE = $request->MODULE_CODE;
		$bitrix->PARTNER_NAME = $request->PARTNER_NAME;
		$bitrix->PARTNER_URI = $request->PARTNER_URI;
		$bitrix->PARTNER_CODE = $request->PARTNER_CODE;
		$bitrix->VERSION = $request->MODULE_VERSION;
		$bitrix->user_id = $user_id;
		$bitrix->save();
		$module_id = $bitrix->id;

		if ($module_id){
			// создание папки модуля пользователя на серваке
			$bitrix::createFolder($request, $module_id); // todo проверка на успех

			return $module_id;
		}
	}

	// создание папки с модулем на серваке
	// todo проверка защиты
	public
	static function createFolder(Request $request, $module_id){ // todo мне нужен здесь $request по сути
		$myModuleFolder = $request->PARTNER_CODE.".".$request->MODULE_CODE; // папка модуля // todo так можно скачать модуль, зная всего два эти параметра, а они открытые (Если вообще можно обращаться к этим папкам)

		// воссоздаём начальную структуру
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/install");
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/lib");

		// подставляем значения в шаблон индексного файла и шагов установки
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/index.php', $module_id);
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/step.php', $module_id);
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/unstep.php', $module_id);

		// подставляем значения в файл версии
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/version.php', $module_id);

		// этот файл просто до сих пор обязательный
		Bitrix::changeVarsInModuleFileAndSave('bitrix/include.php', $module_id);

		// воссоздаём начальную структуру для ланга
		Storage::disk('user_modules')->makeDirectory($myModuleFolder."/lang/ru/install");
		// подставляем значения в шаблон индексного файла
		Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module_id);
	}

	// подставляем нужные значения в заготовку
	public static function changeVarsInModuleFileAndSave($path, $module_id, $dop_search = [], $dop_replace = []){
		$module = Bitrix::find($module_id);
		$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);
		$template_search = ['{MODULE_CLASS_NAME}', '{MODULE_ID}', '{LANG_KEY}', '{VERSION}', '{DATE_TIME}', '{MODULE_NAME}', '{MODULE_DESCRIPTION}', '{PARTNER_NAME}', '{PARTNER_URI}'];
		$template_replace = [$module->PARTNER_CODE."_".$module->MODULE_CODE, $module->PARTNER_CODE.".".$module->MODULE_CODE, $LANG_KEY, $module->MODULE_VERSION, date('Y-m-d H:i:s'), $module->MODULE_NAME, $module->MODULE_DESCRIPTION, $module->PARTNER_NAME, $module->PARTNER_URI];
		if ($dop_search && is_array($dop_search)){
			foreach ($dop_search as $item){
				$template_search[] = $item; // не думаю, что array_push здесь подходит
			}
		}
		if ($dop_replace && is_array($dop_replace)){
			foreach ($dop_replace as $item){
				$template_replace[] = $item; // не думаю, что array_push здесь подходит
			}
		}

		//dd($template_search);
		//dd($template_search, $template_replace);

		// подставляем нужные значения в шаблон
		$file = Storage::disk('modules_templates')->get($path);
		$file = str_replace($template_search, $template_replace, $file);
		//dd($file);

		// записываем в модуль
		$myModuleFolder = $module->PARTNER_CODE.".".$module->MODULE_CODE; // папка модуля
		$count = 1; // только первое вхождение
		$outputFilePath = str_replace("bitrix", $myModuleFolder, $path, $count); // todo если изменить диск,то можно избавиться от такой замены
		Storage::disk('user_modules')->put($outputFilePath, $file);

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

	// получить папку модуля
	public static function getFolder(Bitrix $module){
		$modulesRootFolder = Storage::disk('user_modules')->getDriver()->getAdapter()->getPathPrefix();
		$folder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		return $modulesRootFolder.$folder;
	}

	// связи с другими моделями
	public function creator(){
		return $this->belongsTo('App\Models\User');
	}
	public function options(){
		return $this->hasMany('App\Models\Modules\BitrixAdminOptions');
	}

	public function ownedBy(User $user){
		return $this->user_id == $user->id;
	}
}
