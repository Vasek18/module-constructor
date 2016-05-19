<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsArbitraryFiles extends Model{
	protected $table = 'bitrix_components_arbitrary_files';
	protected $fillable = ['component_id', 'filename', 'path'];
	public $timestamps = false;

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
