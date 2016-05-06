<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksProps extends Model{
	protected $table = 'bitrix_infoblocks_props';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'type', 'multiple', 'is_required'];
	public $timestamps = false;

	public function generateCreationCode(){
		$code = '';
		$code .= "\t\t".'$this->createIblockProp('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t\t".'"IBLOCK_ID"'." => ".'$iblockID,'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"PROPERTY_TYPE"'." => ".'"'.$this->type.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"MULTIPLE"'." => ".'"'.($this->multiple ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"IS_REQUIRED"'." => ".'"'.($this->is_required ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_PARAM_'.strtoupper($this->code));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}
}