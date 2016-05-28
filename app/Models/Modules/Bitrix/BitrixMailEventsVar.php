<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixMailEventsVar extends Model{
	protected $table = 'bitrix_mail_events_variables';
	protected $fillable = ['mail_event_id', 'code', 'name'];
	public $timestamps = false;

	public function mailEvent(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixMailEvents');
	}

}
