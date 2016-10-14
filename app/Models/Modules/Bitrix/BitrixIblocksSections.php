<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixIblocksSections extends Model{
	protected $table = 'bitrix_infoblocks_sections';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'active', 'picture_src', 'text'];
	public $timestamps = false;

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_SECTION_'.strtoupper($this->code));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}
}