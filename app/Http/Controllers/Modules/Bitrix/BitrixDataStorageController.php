<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksElements;
use Nathanmac\Utilities\Parser\Facades\Parser;

class BitrixDataStorageController extends Controller{
	use UserOwnModule;

	public static $arrayGlue = '_###_';

	// страница настроек для страницы настроек
	public function index(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'     => $module,
			'infoblocks' => $module->infoblocks()->get(),
		];

		//dd($data);

		return view("bitrix.data_storage.index", $data);
	}

	public function add_ib(Bitrix $module, Request $request){
		$data = [
			'module'           => $module,
			'iblock'           => null,
			'properties_types' => BitrixIblocksProps::$types
		];

		//dd($data);

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function store_ib(Bitrix $module, Requests\InfoblockFormRequest $request){
		$params = $request->all();
		unset($params['_token']);
		unset($params['save']);

		$properties = $params["properties"];
		unset($params["properties"]);

		$iblock = BitrixInfoblocks::create([
			'module_id' => $module->id,
			'name'      => $params['NAME'],
			'code'      => $params['CODE'],
			'params'    => json_encode($params) // предыдущие пару параметров дублируются здесь специально, чтобы можно было создавать массив по одному лишь params
		]);

		foreach ($properties["NAME"] as $c => $name){
			if (!$name){
				continue;
			}
			if (!$properties["CODE"][$c]){
				continue;
			}

			BitrixIblocksProps::updateOrCreate(
				[
					'iblock_id' => $iblock->id,
					'code'      => $properties["CODE"][$c]
				],
				[
					'iblock_id'   => $iblock->id,
					'code'        => $properties["CODE"][$c],
					'name'        => $name,
					'sort'        => $properties["SORT"][$c],
					'type'        => $properties["TYPE"][$c],
					'multiple'    => isset($properties["MULTIPLE"][$c]) && $properties["MULTIPLE"][$c] == "Y" ? true : false,
					'is_required' => isset($properties["IS_REQUIRED"][$c]) && $properties["IS_REQUIRED"][$c] == "Y" ? true : false
				]
			);
		}

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]));
	}

	public function xml_ib_import(Bitrix $module, Request $request){
		$file = file_get_contents($request->file->getRealPath());

		$arr = Parser::xml($file);

		$iblock = BitrixInfoblocks::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'      => $arr['Каталог']['БитриксКод'],
			],
			[
				'module_id' => $module->id,
				'name'      => $arr['Каталог']['Наименование'],
				'code'      => $arr['Каталог']['БитриксКод'],
				'params'    => json_encode([
					'NAME'               => $arr['Каталог']['Наименование'],
					'CODE'               => $arr['Каталог']['БитриксКод'],
					'SORT'               => $arr['Каталог']['БитриксСортировка'],
					'LIST_PAGE_URL'      => $arr['Каталог']['БитриксURLСписок'],
					'SECTION_PAGE_URL'   => $arr['Каталог']['БитриксURLРаздел'],
					'DETAIL_PAGE_URL'    => $arr['Каталог']['БитриксURLДеталь'],
					'CANONICAL_PAGE_URL' => $arr['Каталог']['БитриксURLКанонический'],
				])
			]);

		$tempPropArr = [];
		foreach ($arr["Классификатор"]["Свойства"]['Свойство'] as $propArr){
			if (isset($propArr["БитриксТипСвойства"])){ // считаем, что свойство от прочих элементов отличает именно это поле
				BitrixIblocksProps::updateOrCreate(
					[
						'iblock_id' => $iblock->id,
						'code'      => $propArr['БитриксКод']
					],
					[
						'iblock_id'   => $iblock->id,
						'code'        => $propArr['БитриксКод'],
						'name'        => $propArr['Наименование'],
						'sort'        => $propArr["БитриксСортировка"],
						'type'        => $propArr["БитриксТипСвойства"],
						'multiple'    => ($propArr["Множественное"] == 'true') ? true : false,
						'is_required' => ($propArr["БитриксОбязательное"] == 'true') ? true : false
					]
				);

				$tempPropArr[$propArr['Ид']] = $propArr['БитриксКод'];
			}
		}

		foreach ($arr['Каталог']['Товары']['Товар'] as $itemArr){
			$elementArr = [
				'iblock_id' => $iblock->id,
				'name'      => $itemArr['Наименование'],
				'active'    => true,
			];

			$tempPropValArr = [];
			foreach ($itemArr['ЗначенияСвойств']['ЗначенияСвойства'] as $propValArr){
				if ($propValArr['Ид'] == 'CML2_CODE'){
					$elementArr['code'] = $propValArr['Значение'];
				}
				if ($propValArr['Ид'] == 'CML2_SORT'){
					$elementArr['sort'] = $propValArr['Значение'];
				}
				if (isset($tempPropArr[$propValArr['Ид']])){
					$val = $propValArr['Значение'];
					if (is_array($val)){
						$val = implode(static::$arrayGlue, $val);
					}
					if ($val){
						$prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('code', $tempPropArr[$propValArr['Ид']])->first();
						if (!$prop){
							continue;
						}

						$tempPropValArr[$prop->id] = ['value' => $val];
					}
				}
			}

			$element = BitrixIblocksElements::create($elementArr);

			$element->props()->sync($tempPropValArr);
		}

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]));
	}

	public function save_ib(Bitrix $module, BitrixInfoblocks $iblock, Requests\InfoblockFormRequest $request){
		$params = $request->all();
		unset($params['_token']);

		$properties = $params["properties"];
		unset($params["properties"]);
		unset($params['save']);

		//dd($params);

		$iblock->update([
			'name'   => $params['NAME'],
			'params' => json_encode($params, JSON_FORCE_OBJECT) // предыдущие пару параметров дублируются здесь специально, чтобы можно было создавать массив по одному лишь params
		]);

		//dd($properties);

		foreach ($properties["NAME"] as $c => $name){
			if (!$name){
				continue;
			}
			if (!$properties["CODE"][$c]){
				continue;
			}

			BitrixIblocksProps::updateOrCreate(
				[
					'iblock_id' => $iblock->id,
					'code'      => $properties["CODE"][$c]
				],
				[
					'iblock_id'   => $iblock->id,
					'code'        => $properties["CODE"][$c],
					'name'        => $name,
					'sort'        => $properties["SORT"][$c],
					'type'        => $properties["TYPE"][$c],
					'multiple'    => isset($properties["MULTIPLE"][$c]) && $properties["MULTIPLE"][$c] == "Y" ? true : false,
					'is_required' => isset($properties["IS_REQUIRED"][$c]) && $properties["IS_REQUIRED"][$c] == "Y" ? true : false
				]
			);
		}

		BitrixInfoblocks::writeInFile($module);

		//dd();

		return back();
	}

	public function delete_ib(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		$iblock->cleanLangFromYourself();

		BitrixInfoblocks::destroy($iblock->id);

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@index', [$module->id]));
	}

	public function detail_ib(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		$data = [
			'module'           => $module,
			'iblock'           => $iblock,
			'properties'       => $iblock->properties()->orderBy('sort', 'asc')->get(),
			'elements'         => $iblock->elements()->orderBy('sort', 'asc')->get(),
			'properties_types' => BitrixIblocksProps::$types
		];

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function delete_prop(Bitrix $module, BitrixIblocksProps $prop, Request $request){
		$module->changeVarInLangFile($prop->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

		$prop->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function create_element(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		$data = [
			'module'     => $module,
			'iblock'     => $iblock,
			'properties' => $iblock->properties()->orderBy('sort', 'asc')->get(),
		];

		//dd($data);

		return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
	}

	public function store_element(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		$element = BitrixIblocksElements::create([
			'iblock_id' => $iblock->id,
			'name'      => $request['NAME'],
			'code'      => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'      => $request['SORT'],
			'active'    => $request['ACTIVE'] == 'Y' ? true : false,
		]);

		if ($request->props){
			$attachArr = [];
			foreach ($request->props as $code => $val){
				if (!$val){
					continue;
				}
				$prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('code', $code)->first();
				if (!$prop){
					continue;
				}
				if (is_array($val)){
					$val = implode(static::$arrayGlue, $val);
				}

				$attachArr[$prop->id] = ['value' => $val];
			}
			$element->props()->sync($attachArr);
		}

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@show_element', [$module->id, $iblock->id, $element->id]));
	}

	public function show_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){

		$props_vals = [];
		foreach ($element->props as $prop){
			$val = $prop->pivot->value;
			if (strpos($val, static::$arrayGlue) !== false){
				$val = explode(static::$arrayGlue, $val);
			}
			$props_vals[$prop->code] = $val;
		}

		$data = [
			'module'     => $module,
			'iblock'     => $iblock,
			'element'    => $element,
			'props_vals' => $props_vals,
			'properties' => $iblock->properties()->orderBy('sort', 'asc')->get(),
		];

		//dd($data);

		return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
	}

	public function save_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){

		// dd($request->all());

		$element->update([
			'name'   => $request['NAME'],
			'code'   => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'   => $request['SORT'],
			'active' => $request['ACTIVE'] == 'Y' ? true : false,
		]);

		$attachArr = [];
		if ($request->props){
			foreach ($request->props as $code => $val){
				if (!$val){
					continue;
				}
				$prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('code', $code)->first();
				if (!$prop){
					continue;
				}
				if (is_array($val)){
					$val = implode(static::$arrayGlue, $val);
				}

				$attachArr[$prop->id] = ['value' => $val];
			}
			$element->props()->sync($attachArr);
		}

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function delete_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
		$module->changeVarInLangFile($element->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

		$element->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}
}