<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixComponentsPathItem extends Model{
	protected $table = 'bitrix_components_path_items';
	protected $fillable = ['component_id', 'level', 'code', 'name', 'sort'];
	public $timestamps = false;

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
