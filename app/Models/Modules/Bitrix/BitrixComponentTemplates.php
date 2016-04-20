<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentTemplates extends Model{
	protected $table = 'bitrix_components_templates';
	protected $fillable = ['component_id', 'code', 'name'];

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
