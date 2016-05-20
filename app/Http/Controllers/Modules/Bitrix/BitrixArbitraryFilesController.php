<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixArbitraryFilesController extends Controller{

	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$files = $module->arbitraryFiles()->get();

		$data = [
			'module' => $module,
			'files'  => $files
		];

		return view("bitrix.arbitrary_files.index", $data);
	}

	public function create(){
		//
	}

	protected function validatePath($path){
		if (!in_array(substr($path, -1), ['/', '\\'])){
			$path .= '/';
		}
		$path = preg_replace('/\.+/i', '', $path); // защита от ../
		$path = preg_replace('/\\\+/i', '/', $path);
		$path = preg_replace('/\/\/+/i', '/', $path);

		return $path;
	}

	public function store(Bitrix $module, Request $request){
		$file = $request->file('file');
		$path = $this->validatePath($request->path);

		$aFile = BitrixArbitraryFiles::updateOrCreate( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName()
			],
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName()
			]
		);

		$aFile->putFileInModuleFolder($path, $file);

		return back();
	}

	public function show($id){
		//
	}

	public function edit($id){
		//
	}

	public function update(Bitrix $module, BitrixArbitraryFiles $file, Request $request){
		$path = $this->validatePath($request->path);
		if (!$request->filename){
			$filename = $file->filename;
		}
		else{
			$filename = $request->filename;
		}

		$file->deleteFileFromModuleFolder();
		$module->disk()->put($file->getFullPath(false, $path).$filename, $request->code);

		$file->update([
			'filename' => $filename,
			'path' => $path
		]);

		return back();
	}

	public function destroy(Bitrix $module, BitrixArbitraryFiles $file, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$file->delete();

		$file->deleteFileFromModuleFolder();

		return back();
	}
}
