<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentPathItem extends Model{
	protected $table = 'bitrix_component_path_items';
	protected $fillable = ['component_id', 'level', 'code', 'name', 'sort'];

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
