<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix;
use App\Models\Modules\BitrixAdminOptions;
use Illuminate\Support\Facades\DB;
use App\Models\Modules\BitrixAdminOptionsVals;

class BitrixOptionsController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	// страница настроек для страницы настроек
	public function show(Bitrix $module){
		$options = BitrixAdminOptions::where('module_id', $module->id)->get();
		//$options = BitrixAdminOptions::where('module_id', $module->id)->with("vals")->get();
		// вот такой сложный путь, потому что закомментирование сверху почему-то показывает null во вью в поле значений
		foreach($options as $i => $option){
			$options[$i]->vals = BitrixAdminOptionsVals::where('option_id', $option->id)->get();
		}
		//dd($options);
		$options_types = DB::table('bitrix_modules_options_types')->get();

		$data = [
			'module'  => $module,
			'options' => $options,
			'options_types' => $options_types
		];

		//dd($data);

		return view("bitrix.admin_options", $data);
	}

	public function store($module_id, Request $request){
		// удаляем старые свойства, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		BitrixAdminOptions::where('module_id', $module_id)->delete();

		//dd($request);

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
			$options_id = BitrixAdminOptions::store($prop);

			// сохранение опций
			if (count($request['option_'.$i.'_vals_key'])){
				//dd($request['option_'.$i.'_vals_key']);
				foreach ($request['option_'.$i.'_vals_key'] as $io => $option_val_key){
					if (!$option_val_key || !$request['option_'.$i.'_vals_name'][$io]){
						continue;
					}
					$val = new BitrixAdminOptionsVals;
					$val->option_id = $options_id;
					$val->key = $option_val_key;
					$val->name = $request['option_'.$i.'_vals_name'][$io];
					//dd($val);
					$val->save();
				}
			}
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
