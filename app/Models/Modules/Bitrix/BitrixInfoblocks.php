<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class BitrixInfoblocks extends Model{
	protected $table = 'bitrix_infoblocks';
	protected $fillable = ['module_id', 'name', 'code', 'params'];
	public $timestamps = false;

	public function writeInFile(){

	}

	public function getParamsAttribute($value){
		return json_decode($value);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
