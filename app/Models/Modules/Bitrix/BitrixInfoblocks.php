<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Helpers\vFuncParse;

// todo переименовать в BitrixIblock
class BitrixInfoblocks extends Model{

    protected $table = 'bitrix_infoblocks';
    protected $fillable = [
        'module_id',
        'name',
        'code',
        'sort',
        'params'
    ];
    public $timestamps = false;

    public static function writeInFile(Bitrix $module){
        $module_folder = $module->module_folder;
        $path          = $module_folder.'/install/index.php';
        $file          = $module->disk()->get($path);

        $iblocksCreationFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'createNecessaryIblocks');
        $iblocksCreationFunctionCode         = static::generateInfoblocksCreationFunctionCode($module);

        $iblocksDeletionFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'deleteNecessaryIblocks');
        $iblocksDeletionFunctionCode         = static::generateInfoblocksDeletionFunctionCode($module);

        $search  = [
            $iblocksCreationFunctionCodeTemplate,
            $iblocksDeletionFunctionCodeTemplate
        ];
        $replace = [
            $iblocksCreationFunctionCode,
            $iblocksDeletionFunctionCode
        ];
        $file    = str_replace($search, $replace, $file);

        $module->disk()->put($path, $file);

        static::manageHelpersFunctions($module);

        static::writeInLangFile($module);

        return true;
    }

    public static function manageHelpersFunctions($module){
        if ($module->infoblocks()->count()){
            $module->addAdditionalInstallHelpersFunctions([
                'createIblockType',
                'removeIblockType',
                'createIblock'
            ], 'iblock.php');
            $issetProp     = false;
            $issetPropVals = false;
            $issetElement  = false;
            $issetSections = false;
            foreach ($module->infoblocks as $infoblock){
                if ($infoblock->properties()->count()){
                    $issetProp = true;
                    foreach ($infoblock->properties as $property){
                        if ($property->values()->count()){
                            $issetPropVals = true;
                        }
                    }
                }

                if ($infoblock->elements()->count()){
                    $issetElement = true;
                }

                if ($infoblock->sections()->count()){
                    $issetSections = true;
                }
            }

            if ($issetProp){
                $module->addAdditionalInstallHelpersFunctions(['createIblockProp'], 'iblock.php');
            } else{
                $module->removeAdditionalInstallHelpersFunctions(['createIblockProp']);
            }

            if ($issetPropVals){
                $module->addAdditionalInstallHelpersFunctions(['createIblockPropVal'], 'iblock.php');
            } else{
                $module->removeAdditionalInstallHelpersFunctions(['createIblockPropVal']);
            }

            if ($issetElement){
                $module->addAdditionalInstallHelpersFunctions(['createIblockElement'], 'iblock.php');
            } else{
                $module->removeAdditionalInstallHelpersFunctions(['createIblockElement']);
            }

            if ($issetSections){
                $module->addAdditionalInstallHelpersFunctions(['createIblockSection'], 'iblock.php');
            } else{
                $module->removeAdditionalInstallHelpersFunctions(['createIblockSection']);
            }
        } else{
            $module->removeAdditionalInstallHelpersFunctions([
                'createIblockType',
                'removeIblockType',
                'createIblock',
                'createIblockProp',
                'createIblockElement',
                'createIblockSection',
                'createIblockPropVal'
            ]);
        }
    }

    public static function generateInfoblocksCreationFunctionCode($module){
        $code = 'function createNecessaryIblocks(){'.PHP_EOL;
        if ($module->infoblocks()->count()){
            $code .= "\t\t".'$iblockType = $this->createIblockType();'.PHP_EOL;

            foreach ($module->infoblocks()->sorted()->get() as $iblock){
                /** @var BitrixInfoblocks $iblock */
                $code .= $iblock->generateCreationCode();
            }
        } else{
            $code .= "\t"."\t".'return true;'.PHP_EOL;
        }
        $code .= "\t".'}';

        return $code;
    }

    public static function generateInfoblocksDeletionFunctionCode($module){
        $code = 'function deleteNecessaryIblocks(){'.PHP_EOL;
        if ($module->infoblocks()->count()){
            $code .= "\t"."\t".'$this->removeIblockType();'.PHP_EOL;
        } else{
            $code .= "\t"."\t".'return true;'.PHP_EOL;
        }
        $code .= "\t".'}';

        return $code;
    }

    public static function writeInLangFile(Bitrix $module){
        // эти ключи должны всегда быть (todo мб тест какой замутить на самолечение)
        $module->changeVarInLangFile($module->lang_key.'_IBLOCK_TYPE_NAME_EN', $module->module_full_id, '/lang/'.$module->default_lang.'/install/index.php');
        $module->changeVarInLangFile($module->lang_key.'_IBLOCK_TYPE_NAME_RU', $module->name, '/lang/'.$module->default_lang.'/install/index.php');
        $module->changeVarInLangFile($module->lang_key.'_IBLOCK_TYPE_ALREADY_EXISTS', "Такой тип инфоблока уже существует", '/lang/'.$module->default_lang.'/install/index.php'); // todo нужные переводы
        $module->changeVarInLangFile($module->lang_key.'_IBLOCK_ALREADY_EXISTS', "Инфоблок с таким кодом уже существует", '/lang/'.$module->default_lang.'/install/index.php'); // todo нужные переводы
        $module->changeVarInLangFile($module->lang_key.'_IBLOCK_TYPE_DELETION_ERROR', "Ошибка удаления типа инфоблока", '/lang/'.$module->default_lang.'/install/index.php'); // todo нужные переводы

        foreach ($module->infoblocks as $iblock){
            $module->changeVarInLangFile($iblock->lang_key."_NAME", $iblock->name, '/lang/'.$module->default_lang.'/install/index.php');

            foreach ($iblock->properties as $property){
                $module->changeVarInLangFile($property->lang_key."_NAME", $property->name, '/lang/'.$module->default_lang.'/install/index.php');

                if ($property->dop_params){
                    if (isset($property->dop_params["DEFAULT_VALUE"])){
                        $module->changeVarInLangFile($property->lang_key."_DEFAULT_VALUE", $property->dop_params["DEFAULT_VALUE"], '/lang/'.$module->default_lang.'/install/index.php');
                    }
                    if (isset($property->dop_params["HINT"])){
                        $module->changeVarInLangFile($property->lang_key."_HINT", $property->dop_params["HINT"], '/lang/'.$module->default_lang.'/install/index.php');
                    }
                }

                foreach ($property->values as $val){
                    $module->changeVarInLangFile($val->lang_key."_VALUE", $val->value, '/lang/'.$module->default_lang.'/install/index.php');
                }
            }

            foreach ($iblock->elements as $element){
                $module->changeVarInLangFile($element->lang_key."_NAME", $element->name, '/lang/'.$module->default_lang.'/install/index.php');

                foreach ($element->props as $prop){
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

                    if (is_array($val)){
                        if (!$prop->multiple){
                            $val = implode(',', $val);
                        }
                    }

                    if (is_array($val)){
                        foreach ($val as $cVal => $valVal){
                            $module->changeVarInLangFile($element->lang_key.'_PROP_'.$prop->id.'_VALUE_'.$cVal, $valVal, '/lang/'.$module->default_lang.'/install/index.php');
                        }
                    } else{
                        if ($val){
                            $module->changeVarInLangFile($element->lang_key.'_PROP_'.$prop->id.'_VALUE', $val, '/lang/'.$module->default_lang.'/install/index.php');
                        }
                    }
                }
            }

            foreach ($iblock->sections as $section){
                $module->changeVarInLangFile($section->lang_key."_NAME", $section->name, '/lang/'.$module->default_lang.'/install/index.php');
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function generateCreationCode(){
        $code = '';
        $code .= "\t\t".$this->php_var_name.' = $this->createIblock('.PHP_EOL;
        $code .= "\t\t\t".'Array('.PHP_EOL;
        $code .= "\t\t\t\t".'"IBLOCK_TYPE_ID" => $iblockType,'.PHP_EOL;
        $code .= "\t\t\t\t".'"ACTIVE" => "Y",'.PHP_EOL;
        $code .= "\t\t\t\t".'"LID" => $this->getSitesIdsArray(),'.PHP_EOL;
        // dd($this->params);
        $code .= $this->getParamCodeForCreationArray($this->params, 4);
        $code .= "\t\t\t".')'.PHP_EOL;
        $code .= "\t\t".');'.PHP_EOL;

        foreach ($this->properties as $property){
            /** @var BitrixIblocksProps $property */
            $code .= $property->generateCreationCode(2);
        }

        foreach ($this->sections as $section){
            /** @var BitrixIblocksSections $section */
            $code .= $section->generateCreationCode(2);
        }

        foreach ($this->elements as $element){
            /** @var BitrixIblocksElements $element */
            $code .= $element->generateCreationCode();
        }

        return $code;
    }

    public function getParamCodeForCreationArray($params, $indents = 0, $parentProp = false){
        $answer = '';
        foreach ($params as $code => $val){
            if (!$val){
                continue;
            }
            if ($code == "NAME" && !$parentProp){
                $val = 'Loc::getMessage("'.$this->lang_key.'_NAME")';
            } else{
                if (is_string($val)){
                    if (strpos($val, 'Array(') === false){ // обычные (не массивы) обрамляем запятыми
                        $val = '"'.$val.'"';
                    }
                } else{
                    // dd($val);
                    $val = (array) $val;
                    if (isset($val["TEMPLATE"]) && $val["TEMPLATE"]){ // гигантский костыль для вкладки SEO Битрикса
                        $modifiers = '';
                        if (isset($val["LOWER"]) && $val["LOWER"] == 'Y'){
                            $modifiers .= 'l';
                        }
                        if (isset($val["TRANSLIT"]) && $val["TRANSLIT"] == 'Y'){
                            $modifiers .= 't';
                            if (isset($val["SPACE"])){
                                $modifiers .= $val["SPACE"];
                            }
                        }
                        $modifiers = $modifiers ? '/'.$modifiers : $modifiers;
                        $val       = '"'.$val["TEMPLATE"].$modifiers.'"';
                    } else{
                        if (isset($val["LOWER"])){
                            continue;
                        }
                        if (isset($val["TRANSLIT"])){
                            continue;
                        }
                        $subVal = $this->getParamCodeForCreationArray($val, $indents + 1, $code);
                        if (!$subVal){
                            continue;
                        }
                        $val = 'Array('.PHP_EOL.$subVal.str_repeat("\t", $indents).')';
                    }
                }
            }

            $answer .= str_repeat("\t", $indents).'"'.$code.'"'.' => '.$val.','.PHP_EOL;
        }

        return $answer;
    }

    public function cleanLangFromYourself(){
        $this->module()->first()->changeVarInLangFile($this->lang_key."_NAME", "", DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');

        foreach ($this->properties as $property){
            $this->module()->first()->changeVarInLangFile($property->lang_key."_NAME", "", DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');

            foreach ($property->values as $val){
                $this->module()->first()->changeVarInLangFile($val->lang_key."_VALUE", "", DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');
            }
        }

        foreach ($this->elements as $element){
            $this->module()->first()->changeVarInLangFile($element->lang_key."_NAME", "", DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');

            foreach ($element->props as $prop){
                $this->module()->first()->changeVarInLangFile($element->lang_key.'_PROP_'.$prop->code.'_VALUE', "", DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');
            }
        }
    }

    public function getIblocksWithLowerSort(){
        return $this->module->infoblocks()->where('sort', '<', $this->sort)->get();
    }

    public function getElementsOfIblocksWithLowerSort(){
        return $this->module->infoblocks()->where('sort', '<', $this->sort)->with('elements')->get();
    }

    public function getSectionsOfIblocksWithLowerSort(){
        return $this->module->infoblocks()->where('sort', '<', $this->sort)->with('sections')->get();
    }

    // свойства вне бд
    public function getLangKeyAttribute(){
        return strtoupper($this->module()->first()->lang_key.'_IBLOCK_'.strtoupper($this->code));
    }

    public function getParamsAttribute($value){
        return json_decode($value);
    }

    public function getPhpVarNameAttribute(){
        return '$iblock'.$this->id.'ID';
    }
    // .свойства вне бд

    // фильтры
    public function scopeSorted($query){
        return $query->orderBy('sort');
    }
    // .фильтры

    // связи с другими моделями
    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

    public function properties(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksProps', 'iblock_id');
    }

    public function elements(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksElements', 'iblock_id');
    }

    public function sections(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksSections', 'iblock_id');
    }
    // .связи с другими моделями
}
