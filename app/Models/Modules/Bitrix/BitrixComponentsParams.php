<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsParams extends Model{
	protected $table = 'bitrix_components_params';
	protected $fillable = ['component_id', 'type_id', 'code', 'name', 'sort'];

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
