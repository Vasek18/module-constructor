<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

class BitrixIblocksProps extends Model{
	protected $table = 'bitrix_infoblocks_props';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'type', 'multiple', 'is_required'];
	public $timestamps = false;

}