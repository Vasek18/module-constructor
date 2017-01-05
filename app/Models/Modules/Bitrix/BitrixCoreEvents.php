<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixCoreEvents extends Model{
	protected $table = 'bitrix_core_events';
	protected $fillable = ['module_id', 'name', 'code', 'params', 'description', 'approved'];
	public $timestamps = false;

}