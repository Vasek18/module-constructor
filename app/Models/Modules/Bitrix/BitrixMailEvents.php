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

	public function vars(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixMailEventsVar', 'mail_event_id');
	}

	public function templates(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixMailEventsTemplate', 'mail_event_id');
	}
}
