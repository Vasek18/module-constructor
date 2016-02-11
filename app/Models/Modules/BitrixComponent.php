<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponent extends Model{
	protected $table = 'bitrix_components';

	// создание компонента
	public static function store($module_id, Request $request){
		$component = new BitrixComponent;
		// запись в БД
		$component->module_id = $module_id;
		$component->name = $request->COMPONENT_NAME;
		$component->desc = $request->COMPONENT_DESCRIPTION;
		$component->code = $request->COMPONENT_CODE;
		$component->save();
		$id = $component->id;

		if ($id){
			return $id;
		}
	}
}
