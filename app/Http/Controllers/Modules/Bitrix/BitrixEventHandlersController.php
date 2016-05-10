<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BitrixEventHandlersController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	// страница обработчиков событий
	public function index(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$handlers = $module->handlers()->get();
		$core_modules = DB::table('bitrix_core_modules')->get();
		$core_events = DB::table('bitrix_core_events')->get();
		$data = [
			'module'   => $module,
			'handlers' => $handlers,
			'core_modules' => $core_modules,
			'core_events' => $core_events
		];

		return view("bitrix.events_handlers.events_handlers", $data); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	// сохранение обработчиков
	public function store(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		//dd($request);
		// удаляем старые обработчики, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		$module->handlers()->delete();
		// удаляем удаляем их файлы
		Storage::disk('user_modules')->deleteDirectory($module->module_folder."/lib/eventhandlers");

		// перебираем все строки полей
		foreach ($request->event as $i => $event){
			$handler = [];
			if (!$event){ // отметаем пустые строки
				continue;
			}
			// обязательные поля
			if (!$request['class'][$i]){
				continue;
			}
			if (!$request['method'][$i]){
				continue;
			}
			if (!$request['from_module'][$i]){
				continue;
			}

			$handler["event"] = $event;
			$handler["from_module"] = $request['from_module'][$i];
			$handler["class"] = $request['class'][$i];
			$handler["method"] = $request['method'][$i];
			$handler["php_code"] = trim($request['php_code'][$i]);
			//dd($handler);

			// записываем в бд
			BitrixEventsHandlers::store($module, $handler);
		}

		// записываем в папку модуля
		BitrixEventsHandlers::saveEventsInFolder($module->id);

		return back();
	}

	// удаление обработчика
	public function destroy($module_id, $handler_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		if (!$handler_id || !$module_id){
			return false;
		}
		// удаляем запись из БД
		BitrixEventsHandlers::destroy($handler_id);

		// производим замены в папке модуля
		BitrixEventsHandlers::saveEventsInFolder($module_id);

		return back();
	}
}
