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

class BitrixComponentsArbitraryFilesController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'     => $module,
			'component'  => $component,
			'path_items' => $component->path_items()->get()
		];

		return view("bitrix.components.arbitrary_files.index", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		$file = $request->file('new_file');
		$addPath = $request->path;
		//dd($request);
		$file->move($component->getFolder(true).$addPath, $file->getClientOriginalName());

		$component->saveStep(5);

		return back();
	}

	public function destroy(){
		
	}
}
