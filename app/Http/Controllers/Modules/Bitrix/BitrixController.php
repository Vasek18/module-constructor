<?php

namespace App\Http\Controllers\Modules\Bitrix;


use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Traits\UserOwnModule;

// todo
// вообще во всех методах надо проверять авторство
// много копипаста, например, код отвечающий за настройки и обработчики практически одинаков

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	use UserOwnModule;

	/*
	|--------------------------------------------------------------------------
	| Контролер для создания модулей на Битриксе
	|--------------------------------------------------------------------------
	|
	|
	*/
	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(){
		return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	public function store(Requests\BitrixCreateRequest $request){
		// создание записи в бд и шаблона
		$id = Bitrix::store($request);

		return redirect(action('Modules\Bitrix\BitrixController@detail', $id));
	}

	// детальная страница модуля
	public function detail(Bitrix $module, Request $request){
		//upgradeVersionNumber("0.0.1");
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		//dd($id);
		$data = [
			'module' => $module
		];

		//dd(Bitrix::where("id", $id)->get());
		return view("bitrix.detail", $data);
	}

	// редактирование параметра
	public function edit_param($id, Request $request){
		$module = Bitrix::find($id);

		if (!$this->userCreatedModule($id)){
			return $this->unauthorized($request);
		}
		if ($request->module_name){
			$module->MODULE_NAME = $request->module_name;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);
		}
		if ($request->module_description){
			$module->MODULE_DESCRIPTION = $request->module_description;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);

		}

		return redirect(action('Modules\Bitrix\BitrixController@detail', $id));
	}

	// кнопка скачивания зип архива
	// todo нельзя скачать модуль, если он не оплачен
	// todo нельзя указать версию ниже нынешней
	// todo нельзя указать последнюю версию, если были произведены изменения
	public function download_zip(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		//dd($request->version);

		Bitrix::upgradeVersion($module->id, $request->version);
		Bitrix::updateDownloadCount($module->id);

		if ($pathToZip = Bitrix::generateZip($module->id)){
			return response()->download($pathToZip)->deleteFileAfterSend(true);
		}

		return back();
	}

	// удаление модуля
	// todo подтверждение удаления
	public function destroy(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		// удаляем папку
		$myModuleFolder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		Storage::disk('user_modules')->deleteDirectory($myModuleFolder);
		// удаляем запись из БД
		$module->delete();

		return redirect(action("PersonalController@index"));
	}
}
