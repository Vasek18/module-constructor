<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\DB;

class BitrixEventHandlersController extends Controller{
	use UserOwnModule;

	// страница обработчиков событий
	public function index(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$handlers = $module->handlers()->get();
		$core_modules = DB::table('bitrix_core_modules')->get();
		$core_events = DB::table('bitrix_core_events')->get();
		$data = [
			'module'       => $module,
			'handlers'     => $handlers,
			'core_modules' => $core_modules,
			'core_events'  => $core_events
		];

		return view("bitrix.events_handlers.index", $data); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	// сохранение обработчиков
	public function store(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		// dd($request->all());

		// удаляем старые обработчики, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		$module->handlers()->delete();
		// удаляем их файлы
		$module->disk()->deleteDirectory($module->module_folder."/lib/eventhandlers");

		// перебираем все строки полей
		foreach ($request["method"] as $i => $method){
			$handlerParams = [];
			// обязательные поля
			if (!$request['class'][$i]){
				continue;
			}
			if (!$request['method'][$i]){
				continue;
			}

			$handlerParams["class"] = $request['class'][$i];
			$handlerParams["method"] = $request['method'][$i];
			$handlerParams["params"] = $request['params'][$i];
			$handlerParams["php_code"] = trim($request['php_code'][$i]);
			//dd($handler);

			// записываем в бд
			$handler = $module->handlers()->create($handlerParams);

			// записываем события к которым привязан обработчик
			foreach ($request["event_".$i] as $j => $event){
				if ($request['from_module_'.$i][$j] && $request['event_'.$i][$j]){
					$handler->events()->create([
						'from_module' => $request['from_module_'.$i][$j],
						'event'       => $request['event_'.$i][$j],
					]);
				}
			}
		}

		// записываем в папку модуля
		BitrixEventsHandlers::saveEventsInFolder($module);

		return back();
	}

	// удаление обработчика
	public function destroy(Bitrix $module, BitrixEventsHandlers $handler, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		if (!$handler->id || !$module->id){
			return false;
		}
		// удаляем запись из БД
		BitrixEventsHandlers::destroy($handler->id);

		// производим замены в папке модуля
		BitrixEventsHandlers::saveEventsInFolder($module);

		// удаляем обработчик
		$module->disk()->delete($handler->file);

		return back();
	}
}
