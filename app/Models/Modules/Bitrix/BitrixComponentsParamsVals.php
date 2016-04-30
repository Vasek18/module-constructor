<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsParamsVals extends Model{
	protected $table = 'bitrix_components_params_vals';
	protected $fillable = ['param_id', 'key', 'value'];
	public $timestamps = false;
}
