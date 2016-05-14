<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

class BitrixArbitraryFiles extends Model{
	protected $table = 'bitrix_arbitrary_files';
	protected $fillable = ['module_id', 'filename', 'path'];
	public $timestamps = false;

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
