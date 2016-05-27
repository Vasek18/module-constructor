<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixMailEvents extends Model{
	protected $table = 'bitrix_mail_events';
	protected $fillable = ['module_id', 'code', 'name', 'sort'];
	public $timestamps = false;

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
