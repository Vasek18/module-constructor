<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;

class BitrixComponentsArbitraryFilesController extends Controller{
	use UserOwnModule;

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'    => $module,
			'component' => $component,
			'files'     => $component->arbitraryFiles()->forAllTemplates()->get()
		];

		return view("bitrix.components.arbitrary_files.index", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$requestArr = $request->all();
		// print_r($requestArr);

		$file = $request->file('file');
		$addPath = $this->validatePath($request->path);
		//dd($request);
		if (!isset($requestArr['template_id'])){
			$file->move($component->getFolder(true).$addPath, $file->getClientOriginalName());
		}else{
			$template = BitrixComponentsTemplates::find($requestArr['template_id']);
			$file->move($template->getFolder(true).$addPath, $file->getClientOriginalName());
		}

		$fileArr = [
			'component_id' => $component->id,
			'path'         => $addPath,
			'filename'     => $file->getClientOriginalName(),
		];
		if (isset($requestArr['template_id'])){
			$fileArr['template_id'] = $requestArr['template_id'];
		}

		$aFile = BitrixComponentsArbitraryFiles::create( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			$fileArr
		);

		$component->saveStep(5);

		return back();
	}

	// todo полная калька с контроллера произвольных файлов
	protected function validatePath($path){
		if (!in_array(substr($path, -1), ['/', '\\'])){
			$path .= '/';
		}
		$path = preg_replace('/\.+/i', '', $path); // защита от ../
		$path = preg_replace('/\\\+/i', '/', $path);
		$path = preg_replace('/\/\/+/i', '/', $path);

		return $path;
	}

	public function destroy(Bitrix $module, BitrixComponent $component, BitrixComponentsArbitraryFiles $file, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentOwnsArbitraryFile($component, $file)){
			return $this->unauthorized($request);
		}

		$file->delete();

		$file->deleteFile();

		return back();
	}
}
