<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsParams extends Model{
	protected $table = 'bitrix_components_params';
	protected $fillable = ['component_id', 'type_id', 'code', 'name', 'sort', 'group_id', 'refresh', 'default', 'size', 'cols', 'multiple', 'default'];

	// todo
	public static function parsePreparedFiles($params_file, $params_lang_file){

	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
