<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Helpers\vFuncParse;

class BitrixInfoblocks extends Model{
	protected $table = 'bitrix_infoblocks';
	protected $fillable = ['module_id', 'name', 'code', 'params'];
	public $timestamps = false;

	public static function writeInFile(Bitrix $module){
		$module_folder = $module->module_folder;
		$path = $module_folder.'/install/index.php';
		$file = $module->disk()->get($path);

		$iblocksCreationFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'createNecessaryIblocks');
		$iblocksCreationFunctionCode = static::generateInfoblocksCreationFunctionCode($module);

		$iblocksDeletionFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'deleteNecessaryIblocks');
		$iblocksDeletionFunctionCode = static::generateInfoblocksDeletionFunctionCode();

		$search = [$iblocksCreationFunctionCodeTemplate, $iblocksDeletionFunctionCodeTemplate];
		$replace = [$iblocksCreationFunctionCode, $iblocksDeletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		$module->disk()->put($path, $file);

		static::writeInLangFile($module);

		return true;
	}

	public static function generateInfoblocksCreationFunctionCode($module){
		$code = "\t".'function createNecessaryIblocks(){'.PHP_EOL;
		$code .= "\t\t".'$iblockType = $this->createIblockType();'.PHP_EOL;

		foreach ($module->infoblocks as $iblock){
			$code .= $iblock->generateCreationCode();
		}

		$code .= "\t".'}';

		return $code;
	}

	public static function generateInfoblocksDeletionFunctionCode(){
		return "\t".'function deleteNecessaryIblocks(){'.PHP_EOL.
		"\t"."\t".'$this->removeIblockType();'.PHP_EOL.
		"\t".'}';
	}

	public static function writeInLangFile(Bitrix $module){
		return $module->writeInfoblocksLangInfoInFile();
	}

	// todo есть замена в виде findFunctionCodeInTextUsingCommentOnEnd, а вообще надо на vFuncParse перейти
	// protected static function findInfoblockCreationAndDeletionCodeInInstallFile($file, $functionName){
	// 	$beginningCode = "\t".'public function '.$functionName.'(){';
	// 	$beginningPosition = strpos($file, $beginningCode);
	// 	$endingCode = "\t".'} // '.$functionName;
	// 	$endingPosition = strpos($file, $endingCode);
	// 	$codeLength = $endingPosition - $beginningPosition + strlen($endingCode);
	//
	// 	return substr($file, $beginningPosition, $codeLength);
	// }

	public function generateCreationCode(){
		$code = '';
		$code .= "\t\t".'$iblockID = $this->createIblock('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t".'"IBLOCK_TYPE_ID" => $iblockType,'.PHP_EOL;
		$code .= "\t\t\t\t".'"ACTIVE" => "Y",'.PHP_EOL;
		$code .= "\t\t\t\t".'"LID" => "s1",'.PHP_EOL; // todo фактические сайты
		// dd($this->params);
		$code .= $this->getParamCodeForCreationArray($this->params, 4);
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		$properties = $this->properties()->get();
		foreach ($properties as $property){
			$code .= $property->generateCreationCode();
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
			}else{
				if (is_string($val)){
					if (strpos($val, 'Array(') === false){ // обычные (не массивы) обрамляем запятыми
						$val = '"'.$val.'"';
					}
				}else{
					// dd($val);
					$subVal = $this->getParamCodeForCreationArray($val, $indents + 1, $code);
					if (!$subVal){
						continue;
					}
					$val = 'Array('.PHP_EOL.$subVal.str_repeat("\t", $indents).')';
				}
			}

			$answer .= str_repeat("\t", $indents).'"'.$code.'"'.' => '.$val.','.PHP_EOL;
		}

		return $answer;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->lang_key.'_IBLOCK_'.strtoupper($this->code));
	}

	public function getParamsAttribute($value){
		return json_decode($value);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function properties(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksProps', 'iblock_id');
	}
}
