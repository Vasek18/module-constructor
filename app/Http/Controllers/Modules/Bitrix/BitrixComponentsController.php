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
use Illuminate\Support\Facades\Response;

class BitrixComponentsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$components = $module->components()->get();
		$data = [
			'module'     => $module,
			'components' => $components
		];

		return view("bitrix.components.index", $data);
	}

	// страница добавления компонента
	public function create(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module' => $module,
		];

		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function store(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$component = BitrixComponent::store($module, $request);

		$component->createFolder();
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

	public function update(Bitrix $module, BitrixComponent $component, Request $request){

		if ($request->name){
			$component->name = $request->name;
			$component->save();

			$component->saveDescriptionLangFileInFolder();
		}

		if ($request->desc){
			$component->desc = $request->desc;
			$component->save();

			$component->saveDescriptionLangFileInFolder();
		}

		if ($request->sort){
			$component->sort = $request->sort;
			$component->save();

			$component->saveDescriptionFileInFolder();
		}

		if (!$request->ajax()){
			return redirect(action('Modules\Bitrix\BitrixComponentsController@index', $module->id));
		}
	}

	// todo проверка на возможность скачивания
	// todo файлы и папки начинающиеся с .
	public function download(Bitrix $module, BitrixComponent $component, Request $request){
		if ($pathToZip = $component->generateZip()){
			$response = Response::download($pathToZip)->deleteFileAfterSend(true);
			ob_end_clean(); // без этого архив скачивается поверждённым

			return $response;
		}

		return back();
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
				BitrixComponentsPathItem::updateOrCreate(
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
				BitrixComponentsPathItem::updateOrCreate(
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

	public function show_templates(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'    => $module,
			'component' => $component,
			'templates' => $component->templates()->get()
		];

		return view("bitrix.components.templates", $data);
	}

	public function store_template(Bitrix $module, BitrixComponent $component, Request $request){
		$templateCode = strtolower($request->template_code);
		$template = BitrixComponentsTemplates::updateOrCreate(
			[
				'code'         => $templateCode,
				'component_id' => $component->id
			],
			[
				'component_id' => $component->id,
				'code'         => $templateCode,
				'name'         => $request->template_name
			]
		);

		$archive = $request->file('files');
		if (!$archive){
			$template_php = ''; // todo
			Storage::disk('user_modules')->put($template->getFolder().'\template.php', $template_php);
		}else{
			$fileName = time().$archive->getClientOriginalName();
			$archive->move('user_upload/', $fileName);

			Storage::disk('user_modules')->makeDirectory($component->getFolder().'/templates/'.$templateCode);

			$zipper = new Zipper;
			$zipper->make('user_upload/'.$fileName)->extractTo($component->getFolder(true).'/templates/'.$templateCode);
			$zipper->close();

			unlink('user_upload/'.$fileName);
		}
		$component->saveStep(6);

		return back();
	}

	public function delete_template(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){

		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		if (!$template->id){
			return false;
		}

		Storage::disk('user_modules')->deleteDirectory($template->getFolder());

		// удаляем запись из БД
		BitrixComponentsTemplates::destroy($template->id);

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

	public function destroy(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$component->delete();

		$component->deleteFolder();

		return redirect(route('bitrix_module_components', $module->id));
	}
}
