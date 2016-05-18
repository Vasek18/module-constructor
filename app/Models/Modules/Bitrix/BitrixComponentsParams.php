<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixComponentsParams extends Model{
	protected $table = 'bitrix_components_params';
	protected $fillable = ['component_id', 'type', 'code', 'name', 'sort', 'group_id', 'refresh', 'default', 'size', 'cols', 'multiple', 'default', 'additional_values', 'spec_vals', 'spec_vals_args'];
	public $timestamps = false;

	// todo
	public static function parsePreparedFiles($params_file, $params_lang_file){

	}

	public function getSpecValsFunctionCallAttribute(){
		return "$".$this->spec_vals."(".$this->spec_vals_args.")";
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsParamsVals', "param_id");
	}
}
