<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixIblocksSections extends Model{
	protected $table = 'bitrix_infoblocks_sections';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'active', 'picture_src', 'text'];
	public $timestamps = false;

	public function generateCreationCode(){
		$code = '';
		$code .= "\t\t".'$this->createIblockSection('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t".'"IBLOCK_ID"'." => ".'$iblockID,'.PHP_EOL;
		$code .= "\t\t\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
		$code .= "\t\t\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= "\t\t\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
		$code .= "\t\t\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_SECTION_'.strtoupper($this->code));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}
}