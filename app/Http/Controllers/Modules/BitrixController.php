<?php

namespace App\Http\Controllers\Modules;

use Auth;
use App\Models\Modules\Bitrix;
use App\Models\Modules\BitrixAdminOptions;
use App\Models\Modules\BitrixEventsHandlers;
use App\Models\Modules\BitrixComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
		//dd($id);
		// todo проверка на авторство модуля
		$data = [
			'module' => Bitrix::find($id)
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
		// удаляем связанные свойства
		BitrixAdminOptions::where('module_id', $id)->delete();
		// удаляем связанные обработчики
		BitrixEventsHandlers::where('module_id', $id)->delete();

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
	public function admin_options_save($module_id, Request $request){
		// удаляем старые свойства, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		BitrixAdminOptions::where('module_id', $module_id)->delete();

		// перебираем все строки полей
		foreach ($request->option_code as $i => $option_code){
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

			$prop["module_id"] = $module_id;
			$prop["code"] = $option_code;
			$prop["name"] = $request['option_'.$i.'_name'];
			$prop["type_id"] = $request['option_'.$i.'_type'];
			$prop["height"] = $request['option_'.$i.'_height'];
			$prop["width"] = $request['option_'.$i.'_width'];

			// записываем в бд
			BitrixAdminOptions::store($prop);
		}

		// записываем в папку модуля
		BitrixAdminOptions::saveOptionFile($module_id);

		return redirect(action('Modules\BitrixController@admin_options', $module_id));
	}

	// удаление поля для страницы настроек
	public function admin_option_delete($module_id, $option_id){
		if (!$option_id || !$module_id){
			return false;
		}
		// удаляем запись из БД
		BitrixAdminOptions::destroy($option_id);

		// производим замены в папке модуля
		BitrixAdminOptions::saveOptionFile($module_id);

		return redirect(action('Modules\BitrixController@admin_options', $module_id));
	}

	// страница обработчиков событий
	public function events_handlers($module_id){
		// todo проверка на авторство модуля

		$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();
		$data = [
			'module'   => Bitrix::find($module_id),
			'handlers' => $handlers
		];

		return view("bitrix.events_handlers", $data); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	// сохранение обработчиков
	public function events_handlers_save($module_id, Request $request){
		// удаляем старые обработчики, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		BitrixEventsHandlers::where('module_id', $module_id)->delete();

		// перебираем все строки полей
		foreach ($request->event as $i => $event){
			$handler = [];
			if (!$event){ // отметаем пустые строки
				continue;
			}
			// обязательные поля
			if (!$request['class_'.$i]){
				continue;
			}
			if (!$request['method_'.$i]){
				continue;
			}
			if (!$request['php_code_'.$i]){
				continue;
			}
			if (!$request['from_module_'.$i]){
				continue;
			}

			$handler["module_id"] = $module_id;
			$handler["event"] = $event;
			$handler["from_module"] = $request['from_module_'.$i];
			$handler["class"] = $request['class_'.$i];
			$handler["method"] = $request['method_'.$i];
			$handler["php_code"] = $request['php_code_'.$i];

			// записываем в бд
			BitrixEventsHandlers::store($handler);
		}

		// записываем в папку модуля
		BitrixEventsHandlers::saveEventsInFolder($module_id);

		return redirect(action('Modules\BitrixController@events_handlers', $module_id));
	}

	// удаление обработчика
	public function events_handler_delete($module_id, $handler_id){
		if (!$handler_id || !$module_id){
			return false;
		}
		// удаляем запись из БД
		BitrixEventsHandlers::destroy($handler_id);

		// производим замены в папке модуля
		BitrixEventsHandlers::saveEventsInFolder($module_id);

		return redirect(action('Modules\BitrixController@events_handlers', $module_id));
	}

	// страница списка компонентов модуля
	public function components($module_id){
		$data = [
			'module' => Bitrix::find($module_id),
		];
		return view("bitrix.components", $data);
	}

	// страница добавления компонента
	public function new_components($module_id){
		$data = [
			'module' => Bitrix::find($module_id),
		];
		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function component_create($module_id, Request $request){
		//dd($request->all());
		$id = BitrixComponent::store($module_id, $request);
		//
		return redirect(route('bitrix_module_detail', $module_id));
	}
}
