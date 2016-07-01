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

class BitrixDataStorageController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

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

	public function save_ib(Bitrix $module, BitrixInfoblocks $iblock, Requests\InfoblockFormRequest $request){
		$params = $request->all();
		unset($params['_token']);

		$properties = $params["properties"];
		unset($params["properties"]);
		unset($params['save']);

		//dd($params);

		$iblock->update([
			'name'   => $params['NAME'],
			'code'   => $params['CODE'],
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
		$iblock = $prop->iblock()->first();
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
					$val = implode('_###_', $val);
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
			if (strpos($val, '_###_') !== false){
				$val = explode('_###_', $val);
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
					$val = implode('_###_', $val);
				}

				$attachArr[$prop->id] = ['value' => $val];
			}
			$element->props()->sync($attachArr);
		}

		BitrixInfoblocks::writeInFile($module);

		return back();
	}

	public function delete_element(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
		$element->delete();

		BitrixInfoblocks::writeInFile($module);

		return back();
	}
}