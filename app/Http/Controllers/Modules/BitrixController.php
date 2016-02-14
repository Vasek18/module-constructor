<?php

namespace App\Http\Controllers\Modules;

use Auth;
use App\Models\Modules\Bitrix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

// todo
// вообще во всех методах надо проверять авторство
// много копипаста, например, код отвечающий за настройки и обработчики практически одинаков

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	/*
	|--------------------------------------------------------------------------
	| Контролер для создания модулей на Битриксе
	|--------------------------------------------------------------------------
	|
	|
	*/
	public function __construct(){

	}

	public function index(){
		$user = Auth::user();

		return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	public function store(Requests\BitrixCreateRequest $request){
		// создание записи в бд и шаблона
		$id = Bitrix::store($request);

		return redirect(action('Modules\BitrixController@detail', $id));
	}

	// детальная страница модуля
	public function detail(Bitrix $module){
		//dd($id);
		// todo проверка на авторство модуля
		$data = [
			'module' => $module
		];

		//dd(Bitrix::where("id", $id)->get());
		return view("bitrix.detail", $data);
	}

	// редактирование параметра
	public function edit_param($id, Request $request){
		if ($request->module_name){

		}
		if ($request->module_description){

		}

		return redirect(action('Modules\BitrixController@detail', $id));
	}

	// кнопка скачивания зип архива
	// todo проверка на владение модулем
	public function download_zip($id){
		if ($pathToZip = Bitrix::generateZip($id)){
			return response()->download($pathToZip)->deleteFileAfterSend(true);
		}

		return back();
	}

	// удаление модуля
	// todo проверка на владение модулем
	// todo подтверждение удаления
	public function destroy(Bitrix $module){
		// удаляем папку
		$myModuleFolder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		Storage::disk('user_modules')->deleteDirectory($myModuleFolder);
		// удаляем запись из БД
		$module->delete();

		return redirect(action("PersonalController@index"));
	}
}
