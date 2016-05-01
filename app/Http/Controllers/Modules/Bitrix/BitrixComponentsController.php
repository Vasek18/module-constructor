<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\BitrixComponentsParams;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentsPathItem;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponentsParamsTypes;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Storage;
use App\Models\Modules\Bitrix\BitrixComponentsParamsGroups;
use App\Models\Modules\Bitrix\BitrixComponentsParamsVals;

class BitrixComponentsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		$components = BitrixComponent::where('module_id', $module_id)->get();
		$data = [
			'module'     => Bitrix::find($module_id),
			'components' => $components
		];

		return view("bitrix.components.components", $data);
	}

	// страница добавления компонента
	public function create($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module' => Bitrix::find($module_id),
		];

		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function store(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$component = BitrixComponent::store($module, $request);

		$component->createDefaultPath();
		$component->createDefaultComponentPhp();
		$component->createDefaultTemplate();

		$component->saveStep(1);

		//
		return redirect(action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id]));
	}

	public function show(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.detail", $data);
	}

	public function show_visual_path(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.visual_path", $data);
	}

	public function store_visual_path(Bitrix $module, BitrixComponent $component, Request $request){
		//dd($request);
		if ($request->path_id_1 && $request->path_name_1){ // если нет первых - нет других (хотя можно же сдвигать?)
			BitrixComponentsPathItem::updateOrCreate(
				[
					'level'        => 1,
					'component_id' => $component->id
				],
				[
					'component_id' => $component->id,
					'level'        => 1,
					'code'         => $request->path_id_1,
					'name'         => $request->path_name_1,
					'sort'         => $request->path_sort_1 ? $request->path_sort_1 : 500
				]
			);
			if ($request->path_id_2 && $request->path_name_2){
				BitrixComponentPathItem::updateOrCreate(
					[
						'level'        => 2,
						'component_id' => $component->id
					],
					[
						'component_id' => $component->id,
						'level'        => 2,
						'code'         => $request->path_id_2,
						'name'         => $request->path_name_2,
						'sort'         => $request->path_sort_2 ? $request->path_sort_2 : 500
					]
				);
			}else{
				BitrixComponentsPathItem::where([
					'level'        => 2,
					'component_id' => $component->id
				])->delete();
			}
			if ($request->path_id_3 && $request->path_name_3){ // todo я ж не использую это пока
				BitrixComponentPathItem::updateOrCreate(
					[
						'level'        => 3,
						'component_id' => $component->id
					],
					[
						'component_id' => $component->id,
						'level'        => 3,
						'code'         => $request->path_id_3,
						'name'         => $request->path_name_3,
						'sort'         => $request->path_sort_3 ? $request->path_sort_3 : 500
					]
				);
			}else{
				BitrixComponentsPathItem::where([
					'level'        => 3,
					'component_id' => $component->id
				])->delete();
			}
		}

		$component->saveDescriptionFileInFolder();
		$component->saveDescriptionLangFileInFolder();

		$component->saveStep(2);

		return back();
	}

	public function show_params(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'        => $module,
			'component'     => $component,
			'params'        => $component->params()->get(),
			'params_types'  => BitrixComponentsParamsTypes::all(),
			'params_groups' => BitrixComponentsParamsGroups::all()
		];

		return view("bitrix.components.params", $data);
	}

	public function store_params(Bitrix $module, BitrixComponent $component, Request $request){
		foreach ($request->param_code as $i => $code){
			// обязательные поля
			if (!$code){
				continue;
			}
			if (!$request['param_name'][$i]){
				continue;
			}

			//dd($request);

			$paramArr = [
				'component_id' => $component->id,
				'code'         => $code,
			];
			if (isset($request['param_name'][$i])){
				$paramArr['name'] = $request['param_name'][$i];
			}
			if (isset($request['param_sort'][$i])){
				$paramArr['sort'] = $request['param_sort'][$i];
			}
			if (isset($request['param_type'][$i])){
				$paramArr['type_id'] = $request['param_type'][$i];
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
			//
			//dd($paramArr);
			//dd($request);

			$param = BitrixComponentsParams::updateOrCreate(
				[
					'code'         => $code,
					'component_id' => $component->id
				],
				$paramArr
			);


			// сохранение опций
			if (count($request['param_'.$i.'_vals_key']) && $request['param_'.$i.'_vals_type'] == "array"){
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

	public function upload_params_files(Bitrix $module, BitrixComponent $component, Request $request){
		$params_file = $request->file('params_file');
		$params_lang_file = $request->file('params_lang_file');
		$params_file->move($component->getFolder(true), $params_file->getClientOriginalName());
		$params_lang_file->move($component->getFolder(true).'/lang/ru', $params_lang_file->getClientOriginalName()); // todo другие языки

		BitrixComponentsParams::parsePreparedFiles($params_file, $params_lang_file);

		$component->saveStep(3);

		return back();
	}

	public function delete_param(Bitrix $module, BitrixComponent $component, BitrixComponentsParams $param, Request $request){

		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		if (!$param->id){
			return false;
		}
		// удаляем запись из БД
		BitrixComponentsParams::destroy($param->id);

		return back();
	}

	public function show_component_php(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.component_php", $data);
	}

	public function store_component_php(Bitrix $module, BitrixComponent $component, Request $request){
		$component_php = $request->component_php;
		$component->component_php = $component_php;
		$component->save();

		Storage::disk('user_modules')->put($component->getFolder().'\component.php', $component_php);

		$component->saveStep(4);

		return back();
	}

	public function show_other_files(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.other_files", $data);
	}

	public function store_other_files(Bitrix $module, BitrixComponent $component, Request $request){
		$file = $request->file('new_file');
		$addPath = $request->path;
		//dd($request);
		$file->move($component->getFolder(true).$addPath, $file->getClientOriginalName());

		$component->saveStep(5);

		return back();
	}

	public function show_templates(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'    => $module,
			'component' => $component,
			'templates' => $component->templates()->get()
		];

		return view("bitrix.components.templates", $data);
	}

	public function store_template(Bitrix $module, BitrixComponent $component, Request $request){
		$template = BitrixComponentTemplates::updateOrCreate(
			[
				'code'         => $request->template_code,
				'component_id' => $component->id
			],
			[
				'component_id' => $component->id,
				'code'         => $request->template_code,
				'name'         => $request->template_name
			]
		);

		$template_php = ''; // todo

		Storage::disk('user_modules')->put($template->getFolder().'\template.php', $template_php);

		$component->saveStep(6);

		return back();
	}

	// загрузка архива с компонентом
	// todo сейчас работает только с зипом
	public function upload_zip(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		//dd($request->file('archive'));
		//dd(Storage::disk('user_modules')->);

		$fileName = $this->moveComponentToPublic($request);
		$this->extractComponentToModuleFolder($module, $fileName);
		unlink('user_upload/'.$fileName);
		$this->createComponentsFromFiles($module);

		return redirect(route('bitrix_module_components', $module->id));
	}

	public function moveComponentToPublic(Request $request){
		$archive = $request->file('archive');
		$fileName = time().$archive->getClientOriginalName();
		$archive->move('user_upload/', $fileName);

		return $fileName;
	}

	public function extractComponentToModuleFolder(Bitrix $module, $fileName){
		$moduleFullID = $module->PARTNER_CODE.".".$module->MODULE_CODE; // todo вынести в вычисляемое поле
		// если вдруг папки для компонентов нет => создаём её
		Storage::disk('user_modules')->makeDirectory($moduleFullID."/install/components/".$moduleFullID);

		$moduleFolder = $module::getFolder($module);
		$zipper = new Zipper;
		$zipper->make('user_upload/'.$fileName)->extractTo($moduleFolder.'/install/components/'.$moduleFullID);

		return true;
	}

	public function createComponentsFromFiles($module){
		BitrixComponent::where('module_id', $module->id)->delete();

		$moduleFullID = $module->PARTNER_CODE.".".$module->MODULE_CODE; // todo вынести в вычисляемое поле
		$directories = Storage::disk('user_modules')->directories($moduleFullID."/install/components/");
		//dd($directories);
		foreach ($directories as $componentFolder){
			$dirs = explode("/", $componentFolder);
			$componentCode = $dirs[count($dirs) - 1];
			//dd($component);

			$component = new BitrixComponent;
			$component->module_id = $module->id;
			$component->code = $componentCode;
			$component->save();
		}

	}
}
