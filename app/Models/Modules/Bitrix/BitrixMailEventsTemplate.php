<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixMailEventsTemplate extends Model{
	protected $table = 'bitrix_mail_events_templates';
	protected $fillable = [
		'mail_event_id',
		'code',
		'name',
		'email_from',
		'email_to',
		'email_copy',
		'email_hidden_copy',
		'email_in_reply_to',
		'body'
	];
	public $timestamps = false;

	public function mailEvent(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixMailEvents');
	}

}
