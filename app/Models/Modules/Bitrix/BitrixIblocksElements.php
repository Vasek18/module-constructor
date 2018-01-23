<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksElements extends Model{

    protected $table = 'bitrix_infoblocks_elements';
    protected $fillable = [
        'iblock_id',
        'name',
        'code',
        'sort',
        'active',
        'preview_picture_src',
        'preview_text',
        'detail_picture_src',
        'detail_text',
        'parent_section_id'
    ];
    public $timestamps = false;

    public function generateCreationCode($startingTabs = 0){
        $code = '';
        $code .= str_repeat("\t", $startingTabs).'$this->createIblockElement('.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t".'Array('.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"IBLOCK_ID"'." => ".$this->iblock->php_var_name.','.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs)."\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
        if ($this->parent_section_id){
            $code .= str_repeat("\t", $startingTabs)."\t\t".'"IBLOCK_SECTION_ID"'.' => $section'.$this->parent_section_id.'ID,'.PHP_EOL;
        }
        $code .= $this->generatePropsArrayCode();
        $code .= str_repeat("\t", $startingTabs)."\t".')'.PHP_EOL;
        $code .= str_repeat("\t", $startingTabs).');'.PHP_EOL;

        return $code;
    }

    public function generatePropsArrayCode(){
        $propsCode = '';
        $code      = '';
        if ($this->props){
            foreach ($this->props as $prop){
                $replaceByLoc = true;

                $val = $prop->pivot->value;

                if (strpos($val, '_###_') !== false){
                    $val = explode('_###_', $val);
                    if ($prop->type == 'S:map_google'){
                        if (!$val[0] || !$val[1]){
                            continue;
                        }
                        $val = implode(',', $val);
                    }
                }

                if ($prop->type == 'L'){
                    $val          = '$val'.$val.'ID';
                    $replaceByLoc = false;
                }

                if (!$val){
                    continue;
                }

                if (is_array($val)){
                    $propsCode .= "\t\t\t\t\t".'$prop'.$prop->id.'ID'." => Array(".PHP_EOL;
                    foreach ($val as $cVal => $valVal){
                        if ($replaceByLoc){
                            $propsCode .= "\t\t\t\t\t\t"."".'Loc::getMessage("'.$this->lang_key.'_PROP_'.$prop->id.'_VALUE_'.$cVal.'"),'.PHP_EOL;
                        } else{
                            $propsCode .= "\t\t\t\t\t\t"."".$valVal.','.PHP_EOL;
                        }
                    }
                    $propsCode .= "\t\t\t\t\t"."),".PHP_EOL;
                } else{
                    if ($replaceByLoc){
                        $propsCode .= "\t\t\t\t\t".'$prop'.$prop->id.'ID'." => ".'Loc::getMessage("'.$this->lang_key.'_PROP_'.$prop->id.'_VALUE"),'.PHP_EOL;
                    } else{
                        $propsCode .= "\t\t\t\t\t".'$prop'.$prop->id.'ID'." => ".$val.','.PHP_EOL;
                    }
                }
            }
        }

        if (strlen($propsCode)){
            $code .= "\t\t\t\t".'"PROPERTY_VALUES" => Array('.PHP_EOL;
            $code .= $propsCode;
            $code .= "\t\t\t\t".'),'.PHP_EOL;
        }

        return $code;
    }

    public function getLangKeyAttribute(){
        return strtoupper($this->iblock()->first()->lang_key.'_ELEMENT_'.strtoupper($this->id));
    }

    public function iblock(){
        return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
    }

    public function props(){
        return $this->belongsToMany('App\Models\Modules\Bitrix\BitrixIblocksProps', 'bitrix_infoblocks_elements_props', 'element_id', 'prop_id')->withPivot('value');
    }
}