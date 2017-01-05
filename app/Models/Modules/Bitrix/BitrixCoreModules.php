<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixCoreModules extends Model{
	protected $table = 'bitrix_core_modules';
	protected $fillable = ['name', 'code', 'approved'];
	public $timestamps = false;

	public function approve(){
		$this->approved = true;
		$this->save();
	}

	public function scopeApproved($query){
		return $query->where('approved', true);
	}

	public function scopeUnapproved($query){
		return $query->where('approved', false);
	}
}