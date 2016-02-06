<?php

namespace App\Http\Controllers\Modules;

use App\Models\User;
use Auth;
use App\Models\Modules\Bitrix;
use App\Models\Modules\BitrixAdminOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	/*
	|--------------------------------------------------------------------------
	| Контролер для создания модулей на Битриксе
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Конструктор
	 *
	 * @return void
	 */
	public function __construct(){

	}

	/**
	 * Главная страница
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$user = Auth::user();

		return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	/**
	 * Создание модуля
	 *
	 * @return
	 */
	public function create(Request $request){
		//dd($request->all());

		// валидация
		// todo нет смысла повторять валидацию с условий в html5, тут надо проверять что как в базе и не пропускать атаки из скриптов
		$this->validate($request, [
			'PARTNER_NAME' => 'required|max:255', // exists:table,column
			'MODULE_CODE'  => 'required|max:255',
		]);

		// создание записи в бд и шаблона
		$id = Bitrix::store($request);

		return redirect(action('Modules\BitrixController@detail', $id));
	}


	//protected function validator(array $data){
	//	return Validator::make($data, [
	//		'MODULE_CODE'     => 'required|max:255|unique:bitrixes',
	//	]);
	//}

	// детальная страница модуля
	public function detail($id){
		// todo проверка на авторство модуля
		$data = [
			'module' => Bitrix::find($id)
		];

		//dd(Bitrix::where("id", $id)->get());
		return view("bitrix.detail", $data);
	}

	// кнопка скачивания зип архива
	// todo проверка на владение модулем
	public function download_zip($id){
		if ($pathToZip = Bitrix::generateZip($id)){
			return response()->download($pathToZip)->deleteFileAfterSend(true);
		}

		return redirect(action('Modules\BitrixController@detail', $id));
	}

	// удаление модуля
	// todo проверка на владение модулем
	// todo подтверждение удаления
	public function delete($id){
		if (!$id){
			return false;
		}
		$module = Bitrix::find($id);
		// удаляем папку
		$myModuleFolder = $module->PARTNER_CODE.".".$module->MODULE_CODE;
		Storage::disk('user_modules')->deleteDirectory($myModuleFolder);
		// удаляем запись из БД
		$module->delete();

		return redirect(action("PersonalController@index"));
	}

	// страница настроек для страницы настроек
	public function admin_options($id){
		$optionsTypes = DB::table('bitrix_modules_options_types')->get();
		$options = BitrixAdminOptions::where('module_id', $id)->get();

		// todo проверка на авторство модуля
		$data = [
			'module'       => Bitrix::find($id),
			'optionsTypes' => $optionsTypes,
			'options'      => $options
		];

		return view("bitrix.admin_options", $data); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	// сохранение полей для страницы настроек
	public function admin_options_save($id, Request $request){
		// перебираем все строки полей
		foreach($request->option_code as $i => $option_code){
			$prop = [];
			if (!$option_code){ // отметаем пустые строки
				continue;
			}
			if (!$request['option_'.$i.'_name']){ // если у поля нет имени
				continue;
			}
			if (!$request['option_'.$i.'_type']){ // если у поля нет типа
				continue;
			}
			$prop["code"] = $option_code;
			$prop["name"] = $request['option_'.$i.'_name'];
			$prop["type"] = $request['option_'.$i.'_type'];
			print_r($prop);
		}
		dd($request);
		//return redirect(action('Modules\BitrixController@detail', $id));

	}
}
