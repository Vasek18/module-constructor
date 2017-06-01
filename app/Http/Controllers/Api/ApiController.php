<?php

namespace App\Http\Controllers\Api;

use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller{
	public function getUserInfo(Request $request){
		return $request->user();
	}

	public function getModulesList(Request $request){
		$modules = $request->user()->modules()->get(['id', 'name', 'description', 'code', 'PARTNER_CODE']);

		$response = [];
		foreach ($modules as $c => $module){
			$moduleArr = [
				'name'         => $module['name'],
				'description'  => $module['description'],
				'code'         => $module['code'],
				'partner_code' => $module['PARTNER_CODE'],
			];
			if (BitrixComponent::where('module_id', $module->id)->count()){
				$moduleArr['components'] = BitrixComponent::where('module_id', $module->id)->get(['name', 'code', 'namespace']);
			}
			if (BitrixInfoblocks::where('module_id', $module->id)->count()){
				$moduleArr['iblocks'] = BitrixInfoblocks::where('module_id', $module->id)->get(['name', 'code']);
			}

			$response[] = $moduleArr;
		}

		return $response;
	}
}
