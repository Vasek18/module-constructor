<?php

namespace App\Http\Controllers\Api;

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Yaml\Tests\B;

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
				$iblocks = BitrixInfoblocks::where('module_id', $module->id)->get(['name', 'code']);
				foreach ($iblocks as $iblock){
					$iblock['type'] = $module->class_name.'_iblock_type';
					$moduleArr['iblocks'][] = $iblock;
				}
			}

			$response[] = $moduleArr;
		}

		return $response;
	}

	public function importIblock($moduleFullCode, Request $request){
		// получаем модуль
		list($partnerCode, $moduleCode) = explode('.', $moduleFullCode);
		$module = Bitrix::where('user_id', $request->user()->id)->where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->first();
		if (!$module){
			return ['error' => 'Not found module'];
		}

		if (!isset($request->IBLOCK['CODE']) || !$request->IBLOCK['CODE']){
			return ['error' => 'No iblock code'];
		}
		if (!isset($request->IBLOCK['NAME']) || !$request->IBLOCK['NAME']){
			return ['error' => 'No iblock name'];
		}
		$iblock = BitrixInfoblocks::where('module_id', $module->id)->where('code', $request->IBLOCK['CODE'])->first();
		// если инфоблока нет, создаём его
		if (!$iblock){
			$iblock = BitrixInfoblocks::create(
				[
					'module_id' => $module->id,
					'code'      => $request->IBLOCK['CODE'],
					'name'      => $request->IBLOCK['NAME'],
					'params'    => json_encode($request->IBLOCK),
				]
			);
		}else{
			$iblock->update(
				[
					'name'   => $request->IBLOCK['NAME'],
					'params' => json_encode($request->IBLOCK),
				]
			);
		}

		BitrixInfoblocks::writeInFile($module);

		return [
			'success' => true,
			'iblock'  => [
				'code' => $iblock->code
			],
		];
	}
}
