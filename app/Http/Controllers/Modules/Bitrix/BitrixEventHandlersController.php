<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;

class BitrixEventHandlersController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	// страница обработчиков событий
	public function show($module_id){
		$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();
		$data = [
			'module'   => Bitrix::find($module_id),
			'handlers' => $handlers
		];

		return view("bitrix.events_handlers.events_handlers", $data); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	// сохранение обработчиков
	public function store($module_id, Request $request){
		//dd($request);
		// удаляем старые обработчики, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		BitrixEventsHandlers::where('module_id', $module_id)->delete();

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

			$handler["module_id"] = $module_id;
			$handler["event"] = $event;
			$handler["from_module"] = $request['from_module'][$i];
			$handler["class"] = $request['class'][$i];
			$handler["method"] = $request['method'][$i];
			$handler["php_code"] = trim($request['php_code'][$i]);
			//dd($handler);

			// записываем в бд
			BitrixEventsHandlers::store($handler);
		}

		// записываем в папку модуля
		BitrixEventsHandlers::saveEventsInFolder($module_id);

		return back();
	}

	// удаление обработчика
	public function destroy($module_id, $handler_id){
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
