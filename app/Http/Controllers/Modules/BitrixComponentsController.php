<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix;
use App\Models\Modules\BitrixAdminOptions;
use App\Models\Modules\BitrixComponent;

class BitrixComponentsController extends Controller{
	public function __construct(){
		$this->middleware('auth');
	}

	public function show($module_id){
		$components = BitrixAdminOptions::where('module_id', $module_id)->get();
		$data = [
			'module'     => Bitrix::find($module_id),
			'components' => $components
		];

		return view("bitrix.components", $data);
	}

	// страница добавления компонента
	public function create($module_id){
		$data = [
			'module' => Bitrix::find($module_id),
		];

		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function store($module_id, Request $request){
		//dd($request->all());
		$id = BitrixComponent::store($module_id, $request);

		//
		return redirect(route('bitrix_module_detail', $module_id));
	}
}
