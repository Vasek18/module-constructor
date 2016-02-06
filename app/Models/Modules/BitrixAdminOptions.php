<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';

	public static function store($fields){
		// todo проверка кода и имени на уникальность (в области этого модуля) (по отдельности)

		$option = new BitrixAdminOptions;

		// запись в БД
		$option->module_id = $fields['module_id'];
		$option->code = $fields['code'];
		$option->name = $fields['name'];
		$option->type_id = $fields['type_id'];
		$option->height = $fields['height'];
		$option->width = $fields['width'];

		if ($option->save()){
			return $option->id;
		}
	}
}
