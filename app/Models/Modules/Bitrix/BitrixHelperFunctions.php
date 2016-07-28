<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixHelperFunctions extends Model{
	protected $table = 'bitrix_helper_functions';
	protected $fillable = ['is_closure', 'name', 'body'];
	public $timestamps = false;

	public function args(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixHelperFunctionsArgs', 'function_id');
	}

}