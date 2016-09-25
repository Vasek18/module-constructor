<?php

namespace App\Models\Modules\Bitrix;

use App\Helpers\vFuncParse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Helpers\vArrParse;
use Illuminate\Filesystem\Filesystem;
use PhpParser\Node\Scalar\MagicConst\File;

class Bitrix extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bitrixes';

	public function disk(){
		return Storage::disk('user_modules_bitrix');
	}

	protected $replaceArray = [
		'{MODULE_CLASS_NAME}'  => 'class_name',
		'{MODULE_ID}'          => 'module_full_id',
		'{LANG_KEY}'           => 'lang_key',
		'{VERSION}'            => 'version',
		'{DATE_TIME}'          => 'updated_at',
		'{MODULE_NAME}'        => 'name',
		'{MODULE_DESCRIPTION}' => 'description',
		'{PARTNER_NAME}'       => 'PARTNER_NAME',
		'{PARTNER_URI}'        => 'PARTNER_URI'
	];

	// на случай, если я где-то буду использовать create, эти поля можно будет записывать
	protected $fillable = ['name', 'description', 'code', 'PARTNER_NAME', 'PARTNER_URI', 'PARTNER_CODE', 'version', 'default_lang', 'last_download'];

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
		$this->disk()->makeDirectory($module_folder."/lang/".$this->default_lang."/install");
		// подставляем значения в шаблон индексного файла
		Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/'.$this->default_lang.'/install/index.php', $this->id);

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
		$outputFilePath = str_replace("bitrix", $module->module_folder, $outputPath ? $outputPath : $path, $count); // todo если изменить диск,то можно избавиться от такой замены
		Storage::disk('user_modules_bitrix')->put($outputFilePath, $file);

	}

	// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
	static public function completeUserProfile($user_id, Request $request){
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
	public function generateZip($encoding, $fresh){
		// чтобы работали файлы с точки, нужно в Illuminate\Filesystem\Filesystem заменить строчку в методе files c $glob = glob($directory.'/*'); на $glob = glob($directory. '/{,.}*', GLOB_BRACE);
		$path = $this->copyToPublicAndEncode($encoding);

		if ($fresh){
			$archiveName = "last_version";
		}else{
			$archiveName = $this->version;
		}
		$archiveName = 'user_downloads/'.$archiveName.'.zip';

		$zipper = new \Chumper\Zipper\Zipper;
		if ($fresh){
			$zipper->make(public_path().'/'.$archiveName)->folder('.last_version')->add($path)->close();
		}else{
			$zipper->make(public_path().'/'.$archiveName)->add($path)->close();
		}

		$Filesystem = new Filesystem;
		$Filesystem->deleteDirectory($path);

		return $archiveName;
	}

	public function copyToPublicAndEncode($encoding = 'UTF-8'){
		$fromFolder = $this->getFolder(true);
		$toFolder = time().rand(0, 100);

		mkdir(public_path().'/'.$toFolder);

		$dirIterator = new \RecursiveDirectoryIterator($fromFolder, \RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $object){
			if (!$object->isDir()){
				$absolutePath = $object->getPath();
				$relativePath = str_replace($fromFolder, "", $absolutePath);
				$fileName = $object->getFilename();
				$content = mb_convert_encoding(file_get_contents($object->getRealPath()), $encoding, 'UTF-8');

				file_put_contents(public_path().'/'.$toFolder.'/'.$relativePath.'/'.$fileName, $content);
			}else{
				$relativePath = str_replace($fromFolder, "", $object->getRealPath());
				if ($relativePath){
					mkdir(public_path().'/'.$toFolder.'/'.$relativePath);
				}
			}
		}

		return public_path().'/'.$toFolder;
	}

	// изменение номера версии у модуля
	public function upgradeVersion($version){
		$this->update(['version' => $version]);

		Bitrix::changeVarsInModuleFileAndSave('bitrix/install/version.php', $this->id);

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
	public function getFolder($fromRoot = true){
		$modulesRootFolder = '';
		if ($fromRoot){
			$modulesRootFolder = $this->disk()->getDriver()->getAdapter()->getPathPrefix();
		}

		return $modulesRootFolder.$this->module_folder;
	}

	public function deleteFolder(){
		$this->disk()->deleteDirectory($this->module_folder);
	}

	// скорее всего уже не используется
	public static function existsModuleWithThisCodeAndPartnerCode($partnerCode, $moduleCode){
		if (Bitrix::where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->count()){
			return true;
		}

		return false;
	}

	public function theSameFolderAlreadyExists(){
		return in_array($this->module_folder, $this->disk()->directories());
	}

	// мб в vArrParse перенести
	// todo перенести работу с лангами всех сущностей Битрикса сюда
	public function changeVarInLangFile($key, $var, $path){
		if (substr($path, 0, 1) != '/'){
			$path = '/'.$path;
		}
		if (strpos($path, '/'.$this->module_folder) !== 0){
			$path = $this->module_folder.$path;
		}
		$var = str_replace('"', '\"', $var);

		if ($this->disk()->exists($path)){
			$langFile = $this->disk()->get($path);
			$vArrParse = new vArrParse;
			$langArr = $vArrParse->parseFromText($langFile, 'MESS');
		}else{
			$langArr = [];
		}

		// записываем переменую
		$langArr[$key] = $var;

		// записываем в файл
		$langCode = '<?'.PHP_EOL;
		foreach ($langArr as $code => $val){
			if (strlen($val)){
				$langCode .= '$MESS["'.$code.'"] = "'.$val.'";'.PHP_EOL;
			}
		}
		$langCode .= '?>';

		$this->disk()->put($path, $langCode);

		return $langCode;
	}

	// todo это наверное какой-то глобальный хелпер должен быть, хоть и актуальный только для Битрикса
	public static function findTemplateToReplaceInLangFile($file, $key){
		$pattern = '/\$MESS\[\"'.$key.'\"\]\s*\=\s*\"[^\"]*\"\;\s*/';
		if (preg_match($pattern, $file, $matches)){
			return $matches[0];
		}else{
			return '?>'; // тип конец файла
		}
	}

	// удаление пустых подпапок
	public function removeEmptySubFolders($path = null){
		if (!$path){
			$path = $this->getFolder(true);
		}

		// dd($path);
		$empty = true;
		foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file){
			$empty &= is_dir($file) && $this->removeEmptySubFolders($file);
		}

		return $empty && rmdir($path);
	}

	public function addAdditionalInstallHelpersFunctions($functionNames = [], $fileName = ''){
		if (!strlen($fileName)){
			return false;
		}
		$file = Storage::disk('modules_templates')->get('/bitrix/install/installhelpers/'.$fileName);
		$installFilePath = $this->getFolder(true).'/install/index.php';
		$installFile = file_get_contents($installFilePath);

		$text = '';
		foreach ($functionNames as $functionName){
			if (strpos($installFile, 'function '.$functionName) !== false){ // если есть, не ставим второй раз (но мб удалять?)
				continue;
			}

			$text .= vFuncParse::getFullCode($file, $functionName).PHP_EOL.PHP_EOL;
		}

		// похожий код есть в changeVarsInModuleFileAndSave, надо бы его вынести
		$template_search = [];
		$template_replace = [];
		foreach ($this->replaceArray as $search => $replace){
			$template_search[] = $search;
			$template_replace[] = $this->$replace;
		}
		$text = str_replace($template_search, $template_replace, $text);

		$posToPaste = vFuncParse::getStartPos($installFile, 'DoInstall');
		$installFile = substr_replace($installFile, $text, $posToPaste, 0);

		file_put_contents($installFilePath, $installFile);
	}

	public function removeAdditionalInstallHelpersFunctions($functionNames = []){
		$installFilePath = $this->getFolder(true).'/install/index.php';
		$installFile = file_get_contents($installFilePath);

		foreach ($functionNames as $functionName){
			if (strpos($installFile, 'function '.$functionName) === false){ // если нет, то и делать ничего не надо
				continue;
			}

			$installFile = str_replace(vFuncParse::getFullCode($installFile, $functionName), '', $installFile);
		}

		file_put_contents($installFilePath, $installFile);
	}

	public function getListOfAllFiles($onlyExtensions = [], $excludeLangs = false){
		$allFiles = $this->disk()->allFiles($this->getFolder(false));

		$files = [];
		foreach ($allFiles as $c => $file){
			$file = preg_replace('/^'.$this->module_folder.'/is', '', $file);
			if ($onlyExtensions){
				preg_match('/^.+\.([^\.]+)$/is', $file, $matches);
				if (isset($matches[1])){
					$ext = $matches[1];
					if (!in_array($ext, $onlyExtensions)){
						continue;
					}
				}else{
					continue; // без расширения файлы в таком случае не берём
				}
			}
			if ($excludeLangs){
				if (strpos($file, '/lang/') !== false){
					continue;
				}
			}

			$files[] = $file;
		}

		return $files;
	}

	public function getLangsArraysForFile($file, $onlyLanguages = []){
		$root = $this->getLangRootForFile($file);
		$fileContent = $this->disk()->get($file);

		$path = str_replace($root, '', $file);

		$langPaths = $this->disk()->directories($root.'/lang');

		$answer = [];
		$allKeys = [];
		foreach ($langPaths as $langPath){
			$langPathArr = explode('/', $langPath);
			$language = $langPathArr[count($langPathArr) - 1];
			if (!empty($onlyLanguages) && !in_array($language, $onlyLanguages)){
				continue;
			}

			$langPath = $langPath.$path;
			if ($this->disk()->exists($langPath)){
				$answer[$language] = vArrParse::parseFromText($this->disk()->get($langPath), "MESS");

				foreach ($answer[$language] as $key => $value){
					$allKeys[$key] = [
						'key'    => $key,
						'unused' => !strpos($fileContent, $key)
					];
				}
			}
		}

		$answer["allKeys"] = $allKeys;

		return $answer;
	}

	public function getLangRootForFile($file){
		$pathArr = explode('/', $file);
		$root = $pathArr[0];
		if (in_array('components', $pathArr)){
			$root = implode('/', array_slice($pathArr, 0, array_search('components', $pathArr) + 3)); // +3 потому что пространство имён ещё нужно и название компонента
		}
		if (in_array('templates', $pathArr)){
			$root = implode('/', array_slice($pathArr, 0, array_search('templates', $pathArr) + 2)); // +2 потому что ещё нужно название шаблона
		}

		return $root;
	}

	public function getAllChangedOrNewFiles(){
		$files = [];

		$modifiedTimestamp = 0;
		if ($this->last_download){
			$modifiedTimestamp = Carbon::parse($this->last_download)->getTimestamp();
		}
		foreach ($this->getListOfAllFiles() as $file){
			$mtimeModified = filemtime($this->getFolder().$file);
			if ($mtimeModified >= $modifiedTimestamp){
				$files[] = $file;
			}
		}

		return $files;
	}

	public function getCanDownloadAttribute(){
		$user = User::find(Auth::id());

		if ($user->money >= $this->priceForDownload){
			return true;
		}

		return false;
	}

	public function getModuleFolderAttribute(){
		return $this->PARTNER_CODE.".".$this->code;
	}

	public function getModuleFullIdAttribute(){
		return $this->PARTNER_CODE.".".$this->code;
	}

	public function getFullIdAttribute(){
		return $this->PARTNER_CODE.".".$this->code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->PARTNER_CODE."_".$this->code);
	}

	public function getClassNameAttribute(){
		return $this->PARTNER_CODE."_".$this->code;
	}

	public function getNamespaceAttribute(){
		return studly_case($this->PARTNER_CODE)."\\".studly_case($this->code);
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

	public function infoblocks(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixInfoblocks', 'module_id');
	}

	public function mailEvents(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixMailEvents', 'module_id');
	}

	public function arbitraryFiles(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixArbitraryFiles', 'module_id');
	}

	public function adminMenuPages(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixAdminMenuItems', 'module_id');
	}

	public function ownedBy(User $user){
		return $this->user_id == $user->id;
	}
}