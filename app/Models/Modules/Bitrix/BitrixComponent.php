<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponent extends Model{
	protected $table = 'bitrix_components';
	protected $fillable = ['name', 'sort', 'code', 'icon_path', 'desc'];


	// создание компонента
	public static function store($module, Request $request){
		$component = new BitrixComponent;
		// запись в БД
		$component->module_id = $module->id;
		$component->name = $request->COMPONENT_NAME;
		$component->desc = $request->COMPONENT_DESCRIPTION;
		$component->code = $request->COMPONENT_CODE;
		$component->sort = $request->COMPONENT_SORT;
		$component->save();

		if ($component->save()){
			return $component;
		}
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
