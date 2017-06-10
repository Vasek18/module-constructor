<?php

namespace App\Http\Controllers\Api;

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixIblocksProps;
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
		$iblockName = $request->IBLOCK['NAME'];
		$iblockCode = $request->IBLOCK['CODE'];
		// если инфоблока нет, создаём его, иначе обновим
		$iblock = BitrixInfoblocks::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'      => $iblockCode,
			],
			[
				'module_id' => $module->id,
				'code'      => $iblockCode,
				'name'      => $iblockName,
				'params'    => json_encode($request->IBLOCK),
			]
		);

		// импортируем свойства
		if ($request->PROPERTIES){
			foreach ($request->PROPERTIES as $propertyArr){

				$prop = BitrixIblocksProps::updateOrCreate(
					[
						'iblock_id' => $iblock->id,
						'code'      => $propertyArr["CODE"]
					],
					[
						'iblock_id'   => $iblock->id,
						'code'        => $propertyArr["CODE"],
						'name'        => $propertyArr['NAME'],
						'sort'        => $propertyArr["SORT"],
						'type'        => $propertyArr["PROPERTY_TYPE"].($propertyArr['USER_TYPE'] ? ':'.$propertyArr['USER_TYPE'] : ''),
						'multiple'    => $propertyArr["MULTIPLE"] == "Y" ? true : false,
						'is_required' => $propertyArr["IS_REQUIRED"] == "Y" ? true : false,
						'dop_params'  => json_encode($propertyArr)
					]
				);

				// todo варианты свойства
				// if ($prop->type = 'L' && isset($properties["VALUES"][$c])){
				// 	foreach ($properties["VALUES"][$c]["VALUE"] as $vc => $valueVal){
				// 		if ($valueVal){
				// 			$val = BitrixIblocksPropsVals::updateOrCreate(
				// 				[
				// 					'prop_id' => $prop->id,
				// 					'value'   => $valueVal
				// 				],
				// 				[
				// 					'prop_id' => $prop->id,
				// 					'value'   => $valueVal,
				// 					'xml_id'  => $properties["VALUES"][$c]["XML_ID"][$vc],
				// 					'sort'    => $properties["VALUES"][$c]["SORT"][$vc],
				// 					'default' => isset($properties["VALUES"][$c]["DEFAULT"]) && $properties["VALUES"][$c]["DEFAULT"] == $vc,
				// 				]
				// 			);
				// 		}
				// 	}
				// }

			}
		}

		// записываем инфоблок в файлы модуля
		BitrixInfoblocks::writeInFile($module);

		return [
			'success' => true,
			'iblock'  => [
				'code' => $iblock->code
			],
		];
	}
}
