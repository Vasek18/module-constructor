<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixIblocksSections extends Model{

    protected $table = 'bitrix_infoblocks_sections';
    protected $fillable = [
        'iblock_id',
        'name',
        'code',
        'sort',
        'active',
        'picture_src',
        'text'
    ];
    public $timestamps = false;

    public function generateCreationCode($startingTabs = 0){
        $code = '';
        $code .= str_repeat("\t", $startingTabs).'$section'.$this->id.'ID = $this->createIblockSection('.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t".'Array('.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"IBLOCK_ID"'." => ".$this->iblock->php_var_name.','.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t".')'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."".');'.PHP_EOL;

        return $code;
    }

    public function getLangKeyAttribute(){
        return strtoupper($this->iblock()->first()->lang_key.'_SECTION_'.strtoupper($this->id));
    }

    public function iblock(){
        return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
    }

    public function elements(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksElements', 'parent_section_id');
    }

    public function sections(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksSections', 'parent_section_id');
    }
}