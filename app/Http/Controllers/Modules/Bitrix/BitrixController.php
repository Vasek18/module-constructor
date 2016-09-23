<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\Bitrix;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Контролер для создания модулей на Битриксе
|--------------------------------------------------------------------------
|
*/

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	protected $request;

	public function __construct(Request $request){
		parent::__construct();
		$this->middleware('auth');

		$this->request = $request;
		// todo почему-то не получило вынести также и модуль
	}

	public function create(){
		return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	public function store(Requests\BitrixCreateRequest $request){
		// создание записи в бд и шаблона
		$bitrix = new Bitrix;

		// на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
		Bitrix::completeUserProfile(Auth::id(), $request);

		// запись в БД
		$bitrix->name = trim($request->MODULE_NAME);
		$bitrix->description = trim($request->MODULE_DESCRIPTION);
		$bitrix->code = trim($request->MODULE_CODE);
		$bitrix->PARTNER_NAME = trim($request->PARTNER_NAME);
		$bitrix->PARTNER_URI = trim($request->PARTNER_URI);
		$bitrix->PARTNER_CODE = trim($request->PARTNER_CODE);
		$version = trim($request->MODULE_VERSION);
		if (!preg_match('/[0-9]+\.[0-9]+\.[0-9]+/is', $version)){
			$version = '0.0.1';
		}
		if ($version == '0.0.0'){
			$version = '0.0.1';
		}
		$bitrix->version = $version;
		$bitrix->default_lang = 'ru'; // todo давать возможность задать

		Auth::user()->bitrixes()->save($bitrix);
		$module_id = $bitrix->id;

		if ($module_id){
			// создание папки модуля пользователя на серваке
			if (!$bitrix->createFolder()){
				return back()->withErrors([trans('bitrix_create.folder_creation_failure')]);;
			}

			return redirect(action('Modules\Bitrix\BitrixController@show', $module_id));
		}

		return back();
	}

	// детальная страница модуля
	public function show(Bitrix $module){

		//dd($id);
		$data = [
			'module' => $module
		];

		//dd(Bitrix::where("id", $id)->get());
		return view("bitrix.detail", $data);
	}

	// редактирование параметра
	public function update(Bitrix $module){

		if ($this->request->name){
			$module->name = $this->request->name;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/'.$module->default_lang.'/install/index.php', $module->id);
		}
		if ($this->request->description){
			$module->description = $this->request->description;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/'.$module->default_lang.'/install/index.php', $module->id);
		}
		if ($this->request->version){
			$module->version = $this->request->version;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/install/version.php', $module->id);
		}

		if (!$this->request->ajax()){
			return redirect(action('Modules\Bitrix\BitrixController@show', $module->id));
		}
	}

	// кнопка скачивания зип архива
	// todo нельзя указать версию ниже нынешней
	// todo нельзя указать последнюю версию, если были произведены изменения
	public function download_zip(Bitrix $module, Request $request){
		$user = User::find(Auth::id());

		if (!$user->canDownloadModule()){
			return response(['message' => 'Nea'], 403);
		}

		$fresh = $request->download_as == 'new' ? true : false;
		// dd($module->code);

		if (!$fresh){
			$module->upgradeVersion($this->request->version);
		}
		// dd($module->version);
		Bitrix::updateDownloadCount($module->id);

		$module->update(['last_download' => Carbon::now()]);

		if ($pathToZip = $module->generateZip($request->files_encoding, $fresh)){
			if ($module->code != 'ololo_from_test'){ // для тестов, иначе эксепшион ловлю // todo придумать что-то поумнее
				$response = Response::download($pathToZip)->deleteFileAfterSend(true);
				ob_end_clean(); // без этого архив скачивается поверждённым

				return $response;
			}
		}

		return back();
	}

	// удаление модуля
	// todo подтверждение удаления
	public function destroy(Bitrix $module){

		// удаляем папку
		$module->deleteFolder();
		// удаляем запись из БД
		$module->delete();

		return redirect(action("PersonalController@index"));
	}
}
