<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use Illuminate\Support\Facades\DB;
use App\Models\Modules\Bitrix\BitrixAdminOptionsVals;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixOptionsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	// страница настроек для страницы настроек
	public function show(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$options = BitrixAdminOptions::where('module_id', $module->id)->orderBy('sort', 'asc')->get();
		//$options = BitrixAdminOptions::where('module_id', $module->id)->with("vals")->get();
		// вот такой сложный путь, потому что закомментирование сверху почему-то показывает null во вью в поле значений
		foreach ($options as $i => $option){
			$options[$i]->vals = BitrixAdminOptionsVals::where('option_id', $option->id)->get();
		}
		//dd($options);
		$options_types = DB::table('bitrix_modules_options_types')->get();

		$data = [
			'module'        => $module,
			'options'       => $options,
			'options_types' => $options_types
		];

		//dd($data);

		return view("bitrix.admin_options.admin_options", $data);
	}

	public function store($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		//dd($request);

		// удаляем старые свойства, чтобы при изменение уже заполненной строчки, старые данные с этой строчки не существовали
		BitrixAdminOptions::where('module_id', $module_id)->delete();
		$module = Bitrix::find($module_id);

		// перебираем все строки полей
		// todo я могу без цикла и перебирания полей обойтись
		foreach ($request->option_code as $i => $option_code){
			$prop = [];
			if (!$option_code){ // отметаем пустые строки
				continue;
			}
			if (!$request['option_name'][$i]){ // если у поля нет имени
				continue;
			}
			if (!$request['option_type'][$i]){ // если у поля нет типа
				continue;
			}
			if ($request['module_id'][$i] != $module_id){ // от хитрых хуесосов
				continue;
			}

			$prop["sort"] = $request['option_sort'][$i];
			$prop["code"] = $option_code;
			$prop["name"] = $request['option_name'][$i];
			$prop["type_id"] = $request['option_type'][$i];
			$prop["height"] = $request['option_height'][$i];
			$prop["width"] = $request['option_width'][$i];
			$prop["spec_vals"] = $request['option_'.$i.'_vals_type'];
			if ($request['option_'.$i.'_spec_args'] && is_array($request['option_'.$i.'_spec_args'])){
				$prop["spec_vals_args"] = '';
				foreach ($request['option_'.$i.'_spec_args'] as $arg){
					if ($arg){
						if (!$prop["spec_vals_args"]){
							$prop["spec_vals_args"] .= $arg;
						}else{
							$prop["spec_vals_args"] .= ', '.$arg;
						}
					}
				}
			}
			if ($request['option_'.$i.'_spec_args'] && !is_array($request['option_'.$i.'_spec_args'])){
				$prop["spec_vals_args"] = $request['option_'.$i.'_spec_args'];
			}

			//dd($prop);
			// записываем в бд
			$option = BitrixAdminOptions::store($module, $prop);

			// сохранение опций
			if ($prop["type_id"] == 3 || $prop["type_id"] == 4){ // todo хардкода
				//dd($request["option_'.$i.'_vals_type"]);
				if (count($request['option_'.$i.'_vals_key']) && $request['option_'.$i.'_vals_type'] == "array"){
					//dd($prop);
					//dd($request['option_'.$i.'_vals_key']);
					foreach ($request['option_'.$i.'_vals_key'] as $io => $option_val_key){
						if (!$option_val_key || !$request['option_'.$i.'_vals_value'][$io]){
							continue;
						}
						$val = new BitrixAdminOptionsVals;
						$val->option_id = $option->id;
						$val->key = $option_val_key;
						$val->value = $request['option_'.$i.'_vals_value'][$io];
						//dd($val);
						$val->save();
					}
				}
			}
		}

		// записываем в папку модуля
		BitrixAdminOptions::saveOptionFile($module_id);

		return back();
	}

	// удаление поля для страницы настроек
	public function destroy($module_id, $option_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
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
