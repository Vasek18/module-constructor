<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixEventsHandlersEvents extends Model{
	protected $table = 'bitrix_event_handlers_module_event_pivot';

	protected $fillable = ['from_module', 'event', 'handler_id'];

	public $timestamps = false;
}