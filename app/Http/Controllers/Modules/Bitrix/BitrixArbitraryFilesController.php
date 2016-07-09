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
			'module'           => $module,
			'files_for_module' => $module->arbitraryFiles()->where('location', 'in_module')->get(),
			'files_for_site'   => $module->arbitraryFiles()->where('location', 'on_site')->get(),
		];

		return view("bitrix.arbitrary_files.index", $data);
	}

	public function create(){
		//
	}

	protected function validatePath($path){
		if (!in_array(substr($path, 0, 1), ['/', '\\'])){
			$path = '/'.$path;
		}
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
		if (!$file){
			return back();
		}
		$path = $this->validatePath($request->path);

		// dd($request->all());

		$aFile = BitrixArbitraryFiles::updateOrCreate( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName(),
				'location'  => $request->location
			],
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName(),
				'location'  => $request->location
			]
		);

		$aFile->putFileInModuleFolder($path, $file, $request->location);

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
		}else{
			$filename = $request->filename;
		}

		$file->deleteFileFromModuleFolder();
		$module->disk()->put($file->getFullPath(false, $path, $request->location).$filename, $request->code);

		$file->update([
			'filename' => $filename,
			'path'     => $path,
			'location' => $request->location
		]);

		return back();
	}

	public function destroy(Bitrix $module, BitrixArbitraryFiles $file, Request $request){
		$file->delete();

		$file->deleteFileFromModuleFolder();

		return back();
	}
}