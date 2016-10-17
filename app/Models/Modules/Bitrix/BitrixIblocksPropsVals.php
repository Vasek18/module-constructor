<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksPropsVals extends Model{
	protected $table = 'bitrix_infoblocks_props_vals';
	protected $fillable = ['prop_id', 'value', 'sort', 'default'];
	public $timestamps = false;

	public function generateCreationCode($startingTabs = 0){
		$code = '';
		$code .= str_repeat("\t", $startingTabs)."".'Array('.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".'"VALUE"'." => ".'Loc::getMessage("'.$this->lang_key.'_VALUE"),'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".'"DEF"'." => ".'"'.($this->default ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."".'),'.PHP_EOL;

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->prop()->first()->lang_key.'_VAL_'.strtoupper($this->id));
	}

	public function prop(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixIblocksProps');
	}
}