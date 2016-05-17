<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsTemplates extends Model{
	protected $table = 'bitrix_components_templates';
	protected $fillable = ['component_id', 'code', 'name'];
	public $timestamps = false;

	public function getFolder(){
		$component_folder = $this->component()->first()->getFolder();

		return $component_folder.'\templates\\'.$this->code;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
