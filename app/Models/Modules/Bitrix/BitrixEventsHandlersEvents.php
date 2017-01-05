<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitrixEventsHandlersEvents extends Model{
	protected $table = 'bitrix_event_handlers_module_event_pivot';

	protected $fillable = ['from_module', 'event', 'handler_id'];

	public $timestamps = false;

	public function getDescriptionAttribute(){
		$event = DB::table('bitrix_core_events')->where('code', $this->event)->first();
		if ($event){
			return $event->description;
		}
	}
}