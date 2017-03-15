<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\BitrixIblocksPropsVals;
use App\Models\Modules\Bitrix\BitrixIblocksSections;
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

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function store_ib(Bitrix $module, Requests\InfoblockFormRequest $request){
		$params = $request->all();
		unset($params['_token']);
		unset($params['save']);

		$iblock = static::create_or_update_ib($module, $params);

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]));
	}

	public function xml_ib_import(Bitrix $module, Request $request){
		$file = file_get_contents($request->file->getRealPath());

		$arr = Parser::xml($file);

		$iblock = BitrixInfoblocks::updateOrCreate(
			[
				'module_id' => $module->id,
				'name'      => $arr['Каталог']['Наименование'],
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
		$vals = [];
		foreach ($arr["Классификатор"]["Свойства"]['Свойство'] as $propArr){
			if (isset($propArr["БитриксТипСвойства"])){ // считаем, что свойство от прочих элементов отличает именно это поле
				$addPropArr = [
					'iblock_id'   => $iblock->id,
					'code'        => $propArr['БитриксКод'],
					'name'        => $propArr['Наименование'],
					'sort'        => $propArr["БитриксСортировка"],
					'type'        => $propArr["БитриксТипСвойства"],
					'multiple'    => ($propArr["Множественное"] == 'true') ? true : false,
					'is_required' => ($propArr["БитриксОбязательное"] == 'true') ? true : false,
				];
				if (isset($propArr["БитриксЗначениеПоУмолчанию"]) && unserialize($propArr["БитриксЗначениеПоУмолчанию"])){
					$addPropArr["dop_params"]["DEFAULT_VALUE"] = unserialize($propArr["БитриксЗначениеПоУмолчанию"]);
				}
				if (isset($propArr["БитриксТипСписка"]) && $propArr["БитриксТипСписка"] != 'L'){
					$addPropArr["dop_params"]["LIST_TYPE"] = $propArr["БитриксТипСписка"];
				}
				$prop = BitrixIblocksProps::updateOrCreate(
					[
						'iblock_id' => $iblock->id,
						'code'      => $propArr['БитриксКод']
					],
					$addPropArr
				);

				if (isset($propArr['ВариантыЗначений']['Вариант']['Ид'])){ // если значение только одно
					$propArr['ВариантыЗначений']['Вариант'] = [$propArr['ВариантыЗначений']['Вариант']];
				}
				if (isset($propArr['ВариантыЗначений']['Вариант'])){
					foreach ($propArr['ВариантыЗначений']['Вариант'] as $valArr){
						if (isset($valArr['Ид'])){
							$vals[$valArr['Ид']] = BitrixIblocksPropsVals::updateOrCreate(
								[
									'prop_id' => $prop->id,
									'value'   => $valArr['Значение']
								],
								[
									'prop_id' => $prop->id,
									'value'   => $valArr['Значение'],
									'sort'    => $valArr["Сортировка"],
									'default' => ($valArr["ПоУмолчанию"] == 'true') ? true : false
								]
							);
						}
					}
				}

				$tempPropArr[$propArr['Ид']] = $propArr['БитриксКод'];
			}
		}

		if (!$request->only_structure){
			// импорт разделов
			$sections = [];
			if (isset($arr['Классификатор']['Группы']) && is_array($arr['Классификатор']['Группы'])){
				if (isset($arr['Классификатор']['Группы']["Группа"]["Ид"])){ // только одна группа
					$sectionsForImport = [$arr['Классификатор']['Группы']["Группа"]];
				}else{ // несколько групп
					$sectionsForImport = $arr['Классификатор']['Группы']["Группа"];
				}
				foreach ($sectionsForImport as $itemArr){
					if (isset($itemArr['Ид'])){
						$sectionArr = [
							'iblock_id' => $iblock->id,
							'name'      => isset($itemArr['Наименование']) ? $itemArr['Наименование'] : '',
							'active'    => true,
							'code'      => isset($itemArr['БитриксКод']) ? $itemArr['БитриксКод'] : '',
						];

						$sections[$itemArr['Ид']] = BitrixIblocksSections::create($sectionArr);
					}
				}
			}
		}

		// импорт элементов
		if (!$request->only_structure){
			if (isset($arr['Каталог']['Товары']) && is_array($arr['Каталог']['Товары'])){ // todo тест на отсутвие товаров в xml
				if (isset($arr['Каталог']['Товары']['Товар']['Ид'])){ // случай одного товар
					$arr['Каталог']['Товары']['Товар'] = Array($arr['Каталог']['Товары']['Товар']);
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

								if (isset($vals[$val])){ // типа xml_id варианта значения
									$val = $vals[$val]->id;
								}

								$tempPropValArr[$prop->id] = ['value' => $val];
							}
						}
					}

					// привязка к группе
					if (isset($itemArr['Группы'])){
						if (isset($itemArr['Группы']['Ид']) && isset($sections[$itemArr['Группы']['Ид']])){
							$elementArr['parent_section_id'] = $sections[$itemArr['Группы']['Ид']]->id;
						}
					}

					$element = BitrixIblocksElements::create($elementArr);

					$element->props()->sync($tempPropValArr);
				}
			}
		}

		BitrixInfoblocks::writeInFile($module);

		flash()->success('Инфоблок импортирован');

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]));
	}

	public function save_ib(Bitrix $module, BitrixInfoblocks $iblock, Requests\InfoblockFormRequest $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$params = $request->all();
		unset($params['_token']);
		unset($params['save']);

		$iblock = static::create_or_update_ib($module, $params, $iblock);

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public static function create_or_update_ib(Bitrix $module, $params, BitrixInfoblocks $iblock = null){
		$properties = $params["properties"];
		unset($params["properties"]);

		if ($iblock){
			$iblock->update([
				'name'   => $params['NAME'],
				'params' => json_encode($params, JSON_FORCE_OBJECT) // предыдущие пару параметров дублируются здесь специально, чтобы можно было создавать массив по одному лишь params
			]);
		}else{
			$iblock = BitrixInfoblocks::create([
				'module_id' => $module->id,
				'name'      => $params['NAME'],
				'code'      => $params['CODE'],
				'params'    => json_encode($params) // предыдущие пару параметров дублируются здесь специально, чтобы можно было создавать массив по одному лишь params
			]);
		}

		foreach ($properties["NAME"] as $c => $name){
			if (!$name){
				continue;
			}
			if (!$properties["CODE"][$c]){
				continue;
			}

			$dop_params = Array();
			foreach ($properties["dop_params"][$c] as $dopParamCode => $dopParamVal){
				if ($dopParamVal){
					$dop_params[$dopParamCode] = $dopParamVal;
				}
			}

			$prop = BitrixIblocksProps::updateOrCreate(
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
					'is_required' => isset($properties["IS_REQUIRED"][$c]) && $properties["IS_REQUIRED"][$c] == "Y" ? true : false,
					'dop_params'  => $dop_params
				]
			);

			if ($prop->type = 'L' && isset($properties["VALUES"][$c])){
				foreach ($properties["VALUES"][$c]["VALUE"] as $vc => $valueVal){
					if ($valueVal){
						$val = BitrixIblocksPropsVals::updateOrCreate(
							[
								'prop_id' => $prop->id,
								'value'   => $valueVal
							],
							[
								'prop_id' => $prop->id,
								'value'   => $valueVal,
								'xml_id'  => $properties["VALUES"][$c]["XML_ID"][$vc],
								'sort'    => $properties["VALUES"][$c]["SORT"][$vc],
								'default' => isset($properties["VALUES"][$c]["DEFAULT"]) && $properties["VALUES"][$c]["DEFAULT"] == $vc,
							]
						);
					}
				}
			}
		}

		return $iblock;
	}

	public function delete_ib(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$iblock->cleanLangFromYourself();

		BitrixInfoblocks::destroy($iblock->id);

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@index', [$module->id]));
	}

	public function detail_ib(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'           => $module,
			'iblock'           => $iblock,
			'properties'       => $iblock->properties()->orderBy('sort', 'asc')->get(),
			'elements'         => $iblock->elements()->where('parent_section_id', null)->orWhere('parent_section_id', 0)->orderBy('sort', 'asc')->get(),
			'sections'         => $iblock->sections()->where('parent_section_id', null)->orWhere('parent_section_id', 0)->orderBy('sort', 'asc')->get(),
			'properties_types' => BitrixIblocksProps::$types
		];

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function delete_prop(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksProps $prop, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsProp($iblock, $prop)){
			return $this->unauthorized($request);
		}

		$module->changeVarInLangFile($prop->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

		$prop->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function create_element(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'     => $module,
			'iblock'     => $iblock,
			'sections'   => $iblock->sections()->orderBy('sort', 'asc')->get(),
			'properties' => $iblock->properties()->orderBy('sort', 'asc')->get(),
		];

		//dd($data);

		return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
	}

	public function store_element(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$element = BitrixIblocksElements::create([
			'iblock_id'         => $iblock->id,
			'name'              => $request['NAME'],
			'code'              => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'              => $request['SORT'],
			'active'            => $request['ACTIVE'] == 'Y' ? true : false,
			'parent_section_id' => $request['SECTION_ID'],
		]);

		if ($request->props){
			$attachArr = [];
			foreach ($request->props as $id => $val){
				if (!$val){
					continue;
				}
				$prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('id', $id)->first();
				if (!$prop){
					continue;
				}
				if (is_array($val)){
					foreach ($val as $cVal => $valVal){
						if (!$valVal){
							unset($val[$cVal]); // удаляем пустые
						}
					}
					$val = implode(static::$arrayGlue, $val);
				}

				$attachArr[$prop->id] = ['value' => $val];
			}
			$element->props()->sync($attachArr);
		}

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@edit_element', [$module->id, $iblock->id, $element->id]));
	}

	public function edit_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsElement($iblock, $element)){
			return $this->unauthorized($request);
		}

		$props_vals = [];
		foreach ($element->props as $prop){
			$val = $prop->pivot->value;
			if (strpos($val, static::$arrayGlue) !== false){
				$val = explode(static::$arrayGlue, $val);
			}
			if ($prop->multiple && !is_array($val)){ // у множественного своства одно значение
				$val = [$val];
			}
			$props_vals[$prop->id] = $val;
		}

		$data = [
			'module'     => $module,
			'iblock'     => $iblock,
			'element'    => $element,
			'props_vals' => $props_vals,
			'properties' => $iblock->properties()->orderBy('sort', 'asc')->get(),
			'sections'   => $iblock->sections()->orderBy('sort', 'asc')->get(),
		];

		//dd($data);

		return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
	}

	public function save_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsElement($iblock, $element)){
			return $this->unauthorized($request);
		}

		// dd($request->all());

		$element->update([
			'name'              => $request['NAME'],
			'code'              => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'              => $request['SORT'],
			'active'            => $request['ACTIVE'] == 'Y' ? true : false,
			'parent_section_id' => $request['SECTION_ID'],
		]);

		$attachArr = [];
		if ($request->props){
			foreach ($request->props as $id => $val){
				if (!$val){
					continue;
				}
				$prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('id', $id)->first();
				if (!$prop){
					continue;
				}
				if (is_array($val)){
					foreach ($val as $cVal => $valVal){
						if (!$valVal){
							unset($val[$cVal]); // удаляем пустые
						}
					}
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
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsElement($iblock, $element)){
			return $this->unauthorized($request);
		}

		$module->changeVarInLangFile($element->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

		$element->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function create_section(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$data = [
			'module' => $module,
			'iblock' => $iblock,
		];

		return view("bitrix.data_storage.iblock_tabs.test_data_section_edit", $data);
	}

	public function store_section(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}

		$section = BitrixIblocksSections::create([
			'iblock_id' => $iblock->id,
			'name'      => $request['NAME'],
			'code'      => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'      => $request['SORT'],
			'active'    => $request['ACTIVE'] == 'Y' ? true : false,
		]);

		BitrixInfoblocks::writeInFile($module);

		return redirect(action('Modules\Bitrix\BitrixDataStorageController@edit_section', [$module->id, $iblock->id, $section->id]));
	}

	public function show_section(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsSection($iblock, $section)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'           => $module,
			'iblock'           => $iblock,
			'properties'       => $iblock->properties()->orderBy('sort', 'asc')->get(),
			'elements'         => $section->elements()->orderBy('sort', 'asc')->get(),
			'sections'         => $section->sections()->orderBy('sort', 'asc')->get(),
			'properties_types' => BitrixIblocksProps::$types,
			'section'          => $section,
		];

		return view("bitrix.data_storage.add_ib", $data);
	}

	public function edit_section(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsSection($iblock, $section)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'  => $module,
			'iblock'  => $iblock,
			'section' => $section,
		];

		return view("bitrix.data_storage.iblock_tabs.test_data_section_edit", $data);
	}

	public function save_section(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsSection($iblock, $section)){
			return $this->unauthorized($request);
		}

		$section->update([
			'name'   => $request['NAME'],
			'code'   => $request['CODE'], // todo проверка на уникальность, если она нужна в этом ИБ
			'sort'   => $request['SORT'],
			'active' => $request['ACTIVE'] == 'Y' ? true : false,
		]);

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function delete_section(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
		if (!$this->moduleOwnsIblock($module, $iblock)){
			return $this->unauthorized($request);
		}
		if (!$this->iblockOwnsSection($iblock, $section)){
			return $this->unauthorized($request);
		}

		$module->changeVarInLangFile($section->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

		$section->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}
}