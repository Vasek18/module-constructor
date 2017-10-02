<?php

namespace App\Helpers;

class PhpCodeGeneration{

    public static $langFuncBeginning = 'Loc::getMessage';

    public static function makeArrayCode($array, $tabsCount = 0, $onEnd = ';'){
        $code = str_repeat("\t", $tabsCount).'Array('.PHP_EOL;
        foreach ($array as $key => $value){
            if (!is_array($value)){
                if (static::isString($value)){
                    $code .= str_repeat("\t", $tabsCount + 1).'"'.$key.'" => "'.$value.'",'.PHP_EOL;
                } else{ // не обрамляется кавычками
                    $code .= str_repeat("\t", $tabsCount + 1).'"'.$key.'" => '.$value.','.PHP_EOL;
                }
            } else{
                $code .= static::makeArrayCode($value, $tabsCount + 1, ','.PHP_EOL);
            }
        }

        $code .= str_repeat("\t", $tabsCount).')'.$onEnd;

        return $code;
    }

    public static function isString($value){
        if (strpos($value, static::$langFuncBeginning) === false){
            return true;
        }

        return false;
    }
}