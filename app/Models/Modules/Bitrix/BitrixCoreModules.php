<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixCoreModules extends Model{
	protected $table = 'bitrix_core_modules';
	protected $fillable = ['name', 'code', 'approved'];
	public $timestamps = false;

	public function scopeApproved($query){
		return $query->where('approved', true);
	}
}