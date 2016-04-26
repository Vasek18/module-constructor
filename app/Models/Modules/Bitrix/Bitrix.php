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

	protected static function disk(){
		return Storage::disk('user_modules');
	}

	protected $replaceArray = [
		'{MODULE_CLASS_NAME}'  => 'class_name',
		'{MODULE_ID}'          => 'module_full_id',
		'{LANG_KEY}'           => 'lang_key',
		'{VERSION}'            => 'VERSION',
		'{DATE_TIME}'          => 'updated_at',
		'{MODULE_NAME}'        => 'MODULE_NAME',
		'{MODULE_DESCRIPTION}' => 'MODULE_DESCRIPTION',
		'{PARTNER_NAME}'       => 'PARTNER_NAME',
		'{PARTNER_URI}'        => 'PARTNER_URI'
	];

	// на случай, если я где-то буду использовать create, эти поля можно будет записывать
	protected $fillable = ['MODULE_NAME', 'MODULE_DESCRIPTION', 'MODULE_CODE', 'PARTNER_NAME', 'PARTNER_URI', 'PARTNER_CODE', 'VERSION'];

	// создание модуля (записывание в бд)
	// todo валидация данных
	public static function store(Request $request){
		$bitrix = new Bitrix;

		if (!Auth::id()){
			// todo выкидывать ошибку
			return false;
		}

		if (Bitrix::existsModuleWithThisCodeAndPartnerCode($request->PARTNER_CODE, $request->MODULE_CODE)){
			//dd($request);
			// todo выкидывать ошибку
			return false;
		}

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
		$bitrix::completeUserProfile(Auth::id(), $request);

		// запись в БД
		$bitrix->MODULE_NAME = trim($request->MODULE_NAME);
		$bitrix->MODULE_DESCRIPTION = trim($request->MODULE_DESCRIPTION);
		$bitrix->MODULE_CODE = trim($request->MODULE_CODE);
		$bitrix->PARTNER_NAME = trim($request->PARTNER_NAME);
		$bitrix->PARTNER_URI = trim($request->PARTNER_URI);
		$bitrix->PARTNER_CODE = trim($request->PARTNER_CODE);
		if ($request->MODULE_VERSION){
			$bitrix->VERSION = trim($request->MODULE_VERSION);
		}

		Auth::user()->bitrixes()->save($bitrix);
		$module_id = $bitrix->id;

		if ($module_id){
			// создание папки модуля пользователя на серваке
			if (!$bitrix->createFolder()){
				// todo возврат ошибки
				return false;
			}

			return $module_id;
		}
	}

	// создание папки с модулем на серваке
	// todo проверка защиты
	public function createFolder(){
		$module_folder = $this->module_folder; // todo так можно скачать модуль, зная всего два эти параметра, а они открытые (Если вообще можно обращаться к этим папкам)
		if (!$module_folder){
			return false;
		}
		if ($this->theSameFolderAlreadyExists()){
			// todo возврат ошибки
			return false;
		}

		// воссоздаём начальную структуру
		$this->disk()->makeDirectory($module_folder."/install");
		$this->disk()->makeDirectory($module_folder."/lib");

		// подставляем значения в шаблон индексного файла и шагов установки
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/index.php', $this->id);
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/step.php', $this->id);
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/unstep.php', $this->id);

		// подставляем значения в файл версии
		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/version.php', $this->id);

		// этот файл просто до сих пор обязательный
		Bitrix::changeVarsInModuleFileAndSave('bitrix/include.php', $this->id);

		// воссоздаём начальную структуру для ланга
		$this->disk()->makeDirectory($module_folder."/lang/ru/install");
		// подставляем значения в шаблон индексного файла
		Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $this->id);

		return true;
	}

	// подставляем нужные значения в заготовку
	// todo избавиться от 'bitrix/..' в $path
	// todo не статик
	public static function changeVarsInModuleFileAndSave($path, $module_id, $dop_search = [], $dop_replace = [], $outputPath = null){
		$module = Bitrix::find($module_id);

		$template_search = [];
		$template_replace = [];
		foreach ($module->replaceArray as $search => $replace){
			$template_search[] = $search;
			$template_replace[] = $module->$replace;
		}
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
		$count = 1; // только первое вхождение
		$outputFilePath = str_replace("bitrix", $module->module_folder, $outputPath?$outputPath:$path, $count); // todo если изменить диск,то можно избавиться от такой замены
		Storage::disk('user_modules')->put($outputFilePath, $file);

	}

	// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
	static private function completeUserProfile($user_id, Request $request){
		$user = User::find($user_id);
		if (!$user->bitrix_partner_code || $user->bitrix_partner_code == ''){
			$user->bitrix_partner_code = $request->PARTNER_CODE;
		}
		if (!$user->bitrix_company_name || $user->bitrix_company_name == ''){
			$user->bitrix_company_name = $request->PARTNER_NAME;
		}
		if (!$user->site){
			$user->site = $request->PARTNER_URI;
		}
		$user->save();
	}

	// форматирование вида даты
	//public function getUpdatedAtAttribute($date){
	//	return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
	//}

	// создаёт архив модуля для скачивания
	// todo проверки на успех
	public static function generateZip(Bitrix $module){
		$folder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		$archiveName = $module->PARTNER_CODE."_".$module->MODULE_CODE.".zip";
		$rootFolder = Storage::disk('user_modules')->getDriver()->getAdapter()->getPathPrefix();

		$zipper = new \Chumper\Zipper\Zipper;
		//$zipper->make($archiveName)->folder("test")->add($rootFolder.$folder);
		$zipper->make($archiveName)->folder($folder)->add($rootFolder.$folder)->close();

		return $archiveName;
	}

	// изменение номера версии у модуля
	public static function upgradeVersion($id, $version){
		$module = Bitrix::find($id);

		$module->VERSION = $version;
		$module->save();

		$module->changeVarsInModuleFileAndSave('bitrix/install/version.php', $module->id);

		return true;
	}

	// увеличиваем счётчик скачиваний
	public static function updateDownloadCount($id){
		$module = Bitrix::find($id);

		$module->download_counter = intval($module->download_counter) + 1;
		$module->save();

		return true;
	}

	// получить папку модуля
	// todo не статик
	public static function getFolder(Bitrix $module, $fromRoot = true){
		$modulesRootFolder = '';
		if ($fromRoot){
			$modulesRootFolder = Storage::disk('user_modules')->getDriver()->getAdapter()->getPathPrefix();
		}
		$folder = $module->PARTNER_CODE.".".$module->MODULE_CODE;

		return $modulesRootFolder.$folder;
	}

	public static function deleteFolder(Bitrix $module){
		$folder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		Storage::disk('user_modules')->deleteDirectory($folder);
	}

	public static function existsModuleWithThisCodeAndPartnerCode($partnerCode, $moduleCode){
		if (Bitrix::where('PARTNER_CODE', $partnerCode)->where('MODULE_CODE', $moduleCode)->count()){
			return true;
		}

		return false;
	}

	public function theSameFolderAlreadyExists(){
		return in_array($this->module_folder, Storage::disk('user_modules')->directories());
	}

	public function getModuleFolderAttribute(){
		return $this->PARTNER_CODE.".".$this->MODULE_CODE;
	}

	public function getModuleFullIdAttribute(){
		return $this->PARTNER_CODE.".".$this->MODULE_CODE;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->PARTNER_CODE."_".$this->MODULE_CODE);
	}

	public function getClassNameAttribute(){
		return $this->PARTNER_CODE."_".$this->MODULE_CODE;
	}

	public function getNamespaceAttribute(){
		return studly_case($this->PARTNER_CODE)."\\".studly_case($this->MODULE_CODE);
	}

	// связи с другими моделями
	public function creator(){
		return $this->belongsTo('App\Models\User');
	}

	public function options(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixAdminOptions', 'module_id');
	}

	public function handlers(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixEventsHandlers', 'module_id');
	}

	public function components(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponent', 'module_id');
	}

	public function ownedBy(User $user){
		return $this->user_id == $user->id;
	}
}
