<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use Illuminate\Support\Facades\DB;
use App\Models\Modules\Bitrix\BitrixAdminOptionsVals;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixInfoblocks;

class BitrixDataStorageController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	// страница настроек для страницы настроек
	public function show(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$data = [
			'module' => $module,
		];

		//dd($data);

		return view("bitrix.data_storage.index", $data);
	}

	public function add_ib(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$data = [
			'module' => $module,
		];

		//dd($data);

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function store_ib(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$params = $request->all();
		unset($params['_token']);

		BitrixInfoblocks::create(['module_id' => $module->id, 'params' => json_encode($params)]);

		return back();
	}
}