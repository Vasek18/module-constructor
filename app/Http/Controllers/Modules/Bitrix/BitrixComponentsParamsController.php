<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\BitrixComponentsParams;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentsParamsTypes;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixComponentsParamsGroups;
use App\Models\Modules\Bitrix\BitrixComponentsParamsVals;

class BitrixComponentsParamsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'        => $module,
			'component'     => $component,
			'params'        => $component->params()->forAllTemplates()->orderBy('sort', 'asc')->get(),
			'params_types'  => BitrixComponentsParamsTypes::all(),
			'params_groups' => BitrixComponentsParamsGroups::all()
		];

		return view("bitrix.components.params.index", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		// dd($request->all());
		foreach ($request->param_code as $i => $code){
			// обязательные поля
			if (!$code){
				continue;
			}

			$paramArr = [
				'component_id' => $component->id,
				'code'         => $code,
			];
			if (isset($request['param_name'][$i])){
				$paramArr['name'] = $request['param_name'][$i];
				if (!$request['param_name'][$i]){
					$paramArr['name'] = BitrixComponentsParams::getSystemPropName($code);
				}
			}
			if (isset($request['param_sort'][$i])){
				$paramArr['sort'] = $request['param_sort'][$i];
			}
			if (isset($request['param_type'][$i])){
				$paramArr['type'] = $request['param_type'][$i];
			}
			if (isset($request['param_group_id'][$i])){
				$paramArr['group_id'] = $request['param_group_id'][$i];
			}
			if (isset($request['param_refresh'][$i])){
				$paramArr['refresh'] = $request['param_refresh'][$i];
			}
			if (isset($request['param_multiple'][$i])){
				$paramArr['multiple'] = $request['param_multiple'][$i];
			}
			if (isset($request['param_cols'][$i])){
				$paramArr['cols'] = $request['param_cols'][$i];
			}
			if (isset($request['param_size'][$i])){
				$paramArr['size'] = $request['param_size'][$i];
			}
			if (isset($request['param_default'][$i])){
				$paramArr['default'] = $request['param_default'][$i];
			}
			if (isset($request['param_additional_values'][$i])){
				$paramArr['additional_values'] = $request['param_additional_values'][$i];
			}
			if (isset($request['param_'.$i.'_vals_type'])){
				$paramArr['spec_vals'] = $request['param_'.$i.'_vals_type'];
			}
			if ($request['param_'.$i.'_spec_args'] && is_array($request['param_'.$i.'_spec_args'])){
				$paramArr["spec_vals_args"] = '';
				foreach ($request['param_'.$i.'_spec_args'] as $arg){
					if ($arg){
						if (!$paramArr["spec_vals_args"]){
							$paramArr["spec_vals_args"] .= $arg;
						}else{
							$paramArr["spec_vals_args"] .= ', '.$arg;
						}
					}
				}
			}
			if ($request['param_'.$i.'_spec_args'] && !is_array($request['param_'.$i.'_spec_args'])){
				$paramArr["spec_vals_args"] = $request['param_'.$i.'_spec_args'];
			}
			if (isset($request['param_template_id'][$i]) && $request['param_template_id'][$i]){
				$paramArr['template_id'] = $request['param_template_id'][$i];
			}
			//
			// dd($paramArr);
			//dd($request);

			$param = BitrixComponentsParams::updateOrCreate(
				[
					'code'         => $code,
					'component_id' => $component->id
				],
				$paramArr
			);
			$param->vals()->delete();

			// сохранение опций
			if (count($request['param_'.$i.'_vals_key']) && $param->spec_vals == "array"){
				//dd($prop);
				//dd($request['param_'.$i.'_vals_key']);
				foreach ($request['param_'.$i.'_vals_key'] as $io => $param_val_key){
					if (!$param_val_key || !$request['param_'.$i.'_vals_value'][$io]){
						continue;
					}
					$val = BitrixComponentsParamsVals::updateOrCreate(
						[
							'param_id' => $param->id,
							'key'      => $param_val_key
						],
						[
							'param_id' => $param->id,
							'key'      => $param_val_key,
							'value'    => $request['param_'.$i.'_vals_value'][$io]
						]
					);
				}
			}

			if ($param->id){
				$component->saveStep(3);
			}
		}

		$component->saveParamsInFile();

		return back();
	}

	public
	function upload_params_files(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$params_file = $request->file('params_file');
		$params_lang_file = $request->file('params_lang_file');
		$params_file->move($component->getFolder(true), $params_file->getClientOriginalName());
		$params_lang_file->move($component->getFolder(true).'/lang/ru', $params_lang_file->getClientOriginalName()); // todo другие языки

		BitrixComponentsParams::parsePreparedFiles($params_file, $params_lang_file);

		$component->saveStep(3);

		return back();
	}

	public
	function destroy(Bitrix $module, BitrixComponent $component, BitrixComponentsParams $param, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsParam($component, $param)){
			return $this->unauthorized($request);
		}

		if (!$param->id){
			return false;
		}
		// удаляем запись из БД
		BitrixComponentsParams::destroy($param->id);

		return back();
	}
}
