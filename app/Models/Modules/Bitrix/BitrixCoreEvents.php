<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Bitrix\BitrixCoreModules;

class BitrixCoreEvents extends Model{
	protected $table = 'bitrix_core_events';
	protected $fillable = ['module_id', 'name', 'code', 'params', 'description', 'approved'];
	public $timestamps = false;

	public function approve(){
		$this->approved = true;
		$this->is_bad = false; // убивая двух зайцев в админке
		$this->save();
	}

	public function markAsBad(){
		$this->is_bad = true;
		$this->save();
	}

	public function getModuleAttribute(){
		return BitrixCoreModules::where('id', $this->module_id)->first();
	}

	public function scopeApproved($query){
		return $query->where('approved', true);
	}

	public function scopeUnapproved($query){
		return $query->where('approved', false);
	}

	public function scopeMarked($query){
		return $query->where('is_bad', true);
	}
}