<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsParamsVals extends Model{
	protected $table = 'bitrix_components_params_vals';
	protected $fillable = ['param_id', 'key', 'value'];
	public $timestamps = false;

	public function getLangKeyAttribute(){
		return strtoupper($this->param()->first()->lang_key.'_'.$this->key);
	}

	public function param(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponentsParams');
	}
}
