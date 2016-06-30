<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksElements extends Model{
	protected $table = 'bitrix_infoblocks_elements';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'active', 'preview_picture_src', 'preview_text', 'detail_picture_src', 'detail_text'];
	public $timestamps = false;

	public function generateCreationCode(){
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_ELEMENT_'.strtoupper($this->code));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}

	public function props(){
		return $this->belongsToMany('App\Models\Modules\Bitrix\BitrixIblocksProps', 'bitrix_infoblocks_elements_props', 'element_id', 'prop_id')->withPivot('value');
	}
}