<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentPathItem;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Storage;

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

	public function store_path(Bitrix $module, BitrixComponent $component, Request $request){
		//dd($request);
		if ($request->path_id_1 && $request->path_name_1){ // если нет первых - нет других (хотя можно же сдвигать?)
			BitrixComponentPathItem::updateOrCreate(
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
				BitrixComponentPathItem::where([
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
				BitrixComponentPathItem::where([
					'level'        => 3,
					'component_id' => $component->id
				])->delete();
			}
		}

		$component->saveDescriptionFileInFolder();
		$component->saveDescriptionLangFileInFolder();

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
