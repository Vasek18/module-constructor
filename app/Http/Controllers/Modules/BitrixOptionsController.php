<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Modules\Bitrix;
use App\Models\Modules\BitrixAdminOptions;

class BitrixOptionsController extends Controller{

	// страница настроек для страницы настроек
	public function show(Bitrix $module){
		$options = BitrixAdminOptions::where('module_id', $module->id)->get();

		$data = [
			'module'       => $module,
			'options'      => $options
		];

		return view("bitrix.admin_options", $data);
	}

	public function store($module_id, Request $request){
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

		return back();
	}

	// удаление поля для страницы настроек
	public function destroy($module_id, $option_id){
		if (!$option_id || !$module_id){
			return false;
		}
		// удаляем запись из БД
		BitrixAdminOptions::destroy($option_id);

		// производим замены в папке модуля
		BitrixAdminOptions::saveOptionFile($module_id);

		return back();
	}

}
