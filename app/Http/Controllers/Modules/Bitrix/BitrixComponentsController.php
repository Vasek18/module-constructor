<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\BitrixComponentClassPhpTemplates;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentsPathItem;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Auth;

// todo мб вообще избавиться от контроллеров
class BitrixComponentsController extends Controller{
	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$components = $module->components()->get();
		$data = [
			'module'     => $module,
			'components' => $components
		];

		return view("bitrix.components.index", $data);
	}

	// страница добавления компонента
	public function create(Bitrix $module, Request $request){
		$data = [
			'module' => $module,
		];

		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function store(Bitrix $module, Request $request){
		$component = BitrixComponent::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'      => $request->code
			],
			[
				'module_id' => $module->id,
				'name'      => $request->name,
				'code'      => $request->code,
				'sort'      => $request->sort,
				'desc'      => $request->desc,
				'namespace' => $request->namespace,
			]
		);

		$component->createFolder();
		$component->createDefaultPath();
		$component->createDefaultComponentPhp();
		$component->createDefaultTemplate();

		$component->saveStep(1);

		flash()->success(trans('bitrix_components.component_created'));

		return redirect(action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id]));
	}

	public function show(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.detail", $data);
	}

	public function update(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

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
			return redirect(action('Modules\Bitrix\BitrixComponentsController@show', [$module, $component]));
		}
	}

	// todo проверка на возможность скачивания
	// todo файлы и папки начинающиеся с .
	public function download(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		$user = User::find(Auth::id());

		if (!$user->canDownloadModule()){
			return response(['message' => 'Nea'], 403);
		}

		if ($pathToZip = $component->generateZip()){
			if ($module->code != 'ololo_from_test'){ // для тестов, иначе эксепшион ловлю // todo придумать что-то поумнее
				$response = Response::download($pathToZip)->deleteFileAfterSend(true);
				ob_end_clean(); // без этого архив скачивается поверждённым

				return $response;
			}
		}

		return back();
	}

	public function show_visual_path(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.visual_path", $data);
	}

	public function store_visual_path(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

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
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'              => $module,
			'component'           => $component,
			'class_php_templates' => BitrixComponentClassPhpTemplates::thatUserCanSee($this->user)->get(),
		];

		return view("bitrix.components.component_php.index", $data);
	}

	public function store_component_php(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$component_php = $request->component_php;
		$class_php = $request->class_php;

		$pathToComponentPhp = $component->getFolder().DIRECTORY_SEPARATOR.'component.php';
		if ($component_php){
			$module->disk()->put($pathToComponentPhp, $component_php);
		}else{
			if ($module->disk()->exists($pathToComponentPhp)){
				$module->disk()->delete($pathToComponentPhp);
			}
		}

		$pathToClassPhp = $component->getFolder().DIRECTORY_SEPARATOR.'class.php';
		if ($class_php){
			$module->disk()->put($pathToClassPhp, $class_php);
		}else{
			if ($module->disk()->exists($pathToClassPhp)){
				$module->disk()->delete($pathToClassPhp);
			}
		}

		$component->saveStep(4);

		return back();
	}

	public function get_logic_files_templates(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		// if (!auth::user()->canSeePaidFiles()){
		// 	return $this->unauthorized($request);
		// }
		$component_php = ''; // его делаем пустым и переезжаем на ооп

		if (!$request->template_id){
			// todo от этой схемы, наверное вообще уйду
			$functions = [];
			foreach ($request->all() as $code => $val){
				// todo тут надо будет удалять лищние параметры
				$functions[] = $val;
			}
			$class_php = $component->getClassPhp($functions);
		}else{
			// шаблоны из бд
			$template = BitrixComponentClassPhpTemplates::find($request->template_id);
			if ($template->userCanUse($this->user)){
				$class_php = $template->template;
			}else{
				$class_php = '';
			}
		}

		return response(['component_php' => $component_php, 'class_php' => $class_php]);
	}

	// загрузка архива с компонентом
	// todo сейчас работает только с зипом
	public function upload_zip(Bitrix $module, Request $request){
		$fileName = $this->moveComponentToPublic($request);
		$this->extractComponentToModuleFolder($module, $fileName);
		$componentCode = $this->getComponentCodeFromFolder($fileName);
		unlink(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$component = $this->createEmptyComponent($module, $componentCode);
		$component->parseDescriptionFile();
		$component->parseParamsFile();
		$component->gatherListOfArbitraryFiles();
		$component->parseTemplates();

		if ($component){
			flash()->success(trans('bitrix_components.component_imported'));

			return redirect(action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id]));
		}

		return redirect(route('bitrix_module_components', $module->id));
	}

	public function moveComponentToPublic(Request $request){
		$archive = $request->file('archive');
		$fileName = time().$archive->getClientOriginalName();
		$archive->move(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR, $fileName);

		return $fileName;
	}

	public function extractComponentToModuleFolder(Bitrix $module, $fileName){
		// если вдруг папки для компонентов нет => создаём её
		$module->disk()->makeDirectory($module->module_full_id.DIRECTORY_SEPARATOR."install".DIRECTORY_SEPARATOR."components".DIRECTORY_SEPARATOR.$module->module_full_id);

		$moduleFolder = $module->getFolder();
		$zipper = new Zipper;
		$zipper->make(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$zipper->extractTo($moduleFolder.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$module->module_full_id);

		return true;
	}

	public function getComponentCodeFromFolder($fileName){ // todo мб есть способ покрасивее
		$zipper = new Zipper;
		$zipper->make(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$files = $zipper->listFiles();
		$path = explode('/', $files[0]);

		return $path[0];
	}

	public function createEmptyComponent(Bitrix $module, $componentCode){
		BitrixComponent::where(['module_id' => $module->id, 'code' => $componentCode])->delete(); // не обновляем, а удаляем, чтобы каскадно удалить записи из связанных таблиц

		$component = new BitrixComponent;
		$component->module_id = $module->id;
		$component->code = $componentCode;
		$component->namespace = $module->full_id;
		$component->save();

		return $component;
	}

	public function destroy(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$component->delete();

		$component->deleteFolder();

		return redirect(route('bitrix_module_components', $module->id));
	}
}
