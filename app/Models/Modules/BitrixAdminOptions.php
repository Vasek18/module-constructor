<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';

	public static function store($fields){
		// если есть поле с таким же кодом, обновляем старое, а не создаём новое
		if (BitrixAdminOptions::where('module_id', $fields["module_id"])->where('code', $fields["code"])->count()){
			$id = BitrixAdminOptions::where('module_id', $fields["module_id"])->where('code', $fields["code"])->first()->id;
			$option = BitrixAdminOptions::find($id);
		}else{
			$option = new BitrixAdminOptions;
			$option->code = $fields['code'];
		}

		// запись в БД
		$option->module_id = $fields['module_id'];
		$option->name = $fields['name'];
		$option->type_id = $fields['type_id'];
		$option->height = $fields['height'];
		$option->width = $fields['width'];

		if ($option->save()){
			return $option->id;
		}
	}
}
