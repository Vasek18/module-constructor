<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;

class BitrixComponentsArbitraryFilesController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'    => $module,
			'component' => $component,
			'files'     => $component->arbitraryFiles()->get()
		];

		return view("bitrix.components.arbitrary_files.index", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		$file = $request->file('new_file');
		$addPath = $this->validatePath($request->path);
		//dd($request);
		$file->move($component->getFolder(true).$addPath, $file->getClientOriginalName());

		$aFile = BitrixComponentsArbitraryFiles::updateOrCreate( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			[
				'component_id' => $component->id,
				'path'         => $addPath,
				'filename'     => $file->getClientOriginalName()
			],
			[
				'component_id' => $component->id,
				'path'         => $addPath,
				'filename'     => $file->getClientOriginalName()
			]
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

		$file->delete();

		$file->deleteFile();

		return back();
	}
}
