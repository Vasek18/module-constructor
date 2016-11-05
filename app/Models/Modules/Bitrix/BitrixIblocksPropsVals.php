<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksPropsVals extends Model{
	protected $table = 'bitrix_infoblocks_props_vals';
	protected $fillable = ['prop_id', 'xml_id', 'value', 'sort', 'default'];
	public $timestamps = false;

	public function generateCreationCode($startingTabs = 0){
		$code = '';
		$code .= str_repeat("\t", $startingTabs).'$val'.$this->id.'ID = $this->createIblockPropVal('.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".'Array('.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"PROPERTY_ID"'." => ".'$prop'.$this->prop_id.'ID,'.PHP_EOL;
		if ($this->xml_id){
			$code .= str_repeat("\t", $startingTabs)."\t\t".'"XML_ID" => "'.$this->xml_id.'",'.PHP_EOL;
		}
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"VALUE"'." => ".'Loc::getMessage("'.$this->lang_key.'_VALUE"),'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"DEF"'." => ".'"'.($this->default ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".')'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs).');'.PHP_EOL;

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->prop()->first()->lang_key.'_VAL_'.strtoupper($this->id));
	}

	public function prop(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixIblocksProps');
	}
}