<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;

class BitrixEventsHandlers extends Model{
	protected $table = 'bitrix_events_handlers';

	public static function store($fields){
		$handler = new BitrixEventsHandlers();

		// запись в БД
		$handler->module_id = $fields['module_id'];
		$handler->event = $fields['event'];
		$handler->class = $fields['class'];
		$handler->method = $fields['method'];
		$handler->php_code = $fields['php_code'];
		//dd($fields);

		if ($handler->save()){
			return $handler->id;
		}
	}

	// сохраняем обработчики в папку модуля
	static public function saveOptionFile($module_id){
		if (BitrixEventsHandlers::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);
			$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);

			$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();
		}
	}
}
