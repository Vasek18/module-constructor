<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixEventsHandlers;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixEventHandlersController extends Controller{
	use UserOwnModule;

	// страница обработчиков событий
	public function index(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$handlers = $module->handlers()->get();
		$core_modules = BitrixCoreModules::approved()->get();
		$core_events = BitrixCoreEvents::approved()->get();
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
		$this->cleanHandlers($module);

		// перебираем все строки полей
		foreach ($request["params"] as $i => $method){
			if (!$request['event_'.$i][0]){ // определяем пустоту по заполненности события
				continue;
			}

			// записываем в бд
			$handler = $module->handlers()->create([
				"class"    => $request['event_'.$i][0].'Handler',
				"method"   => 'handler',
				"params"   => $request['params'][$i],
				"php_code" => trim($request['php_code'][$i]),
			]);

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

		$handler->delete();

		return back();
	}

	/**
	 * @param Bitrix $module
	 */
	public function cleanHandlers(Bitrix $module){
		// удаляем старые обработчики, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		$module->handlers()->delete();
		// удаляем их файлы
		$module->disk()->deleteDirectory($module->module_folder."/lib/eventhandlers");
	}
}
