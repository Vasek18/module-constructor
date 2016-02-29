<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixComponentsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function show($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		$components = BitrixAdminOptions::where('module_id', $module_id)->get();
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
	public function store($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		//dd($request->all());
		$id = BitrixComponent::store($module_id, $request);

		//
		return redirect(route('bitrix_module_detail', $module_id));
	}
}
