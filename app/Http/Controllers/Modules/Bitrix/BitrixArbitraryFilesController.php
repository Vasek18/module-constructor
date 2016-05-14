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
		$data = [
			'module' => $module,
			'files'  => $module->arbitraryFiles()->get()
		];

		return view("bitrix.arbitrary_files.index", $data);
	}

	public function create(){
		//
	}

	public function store(Bitrix $module, Request $request){
		$file = $request->file('file');

		$aFile = BitrixArbitraryFiles::updateOrCreate( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			[
				'module_id' => $module->id,
				'path'      => $request->path,
				'filename'  => $file->getClientOriginalName()
			],
			[
				'module_id' => $module->id,
				'path'      => $request->path,
				'filename'  => $file->getClientOriginalName()
			]
		);

		$aFile->putFileInModuleFolder($request->path, $file);

		return back();
	}

	public function show($id){
		//
	}

	public function edit($id){
		//
	}

	public function update(Request $request, $id){
		//
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
