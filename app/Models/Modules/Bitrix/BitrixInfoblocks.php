<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixInfoblocks extends Model{
	protected $table = 'bitrix_infoblocks';
	protected $fillable = ['module_id', 'name', 'code', 'params'];
	public $timestamps = false;

	public static function writeInFile(Bitrix $module){
		$module_folder = $module->module_folder;
		$path = $module_folder.'/install/index.php';
		$file = $module->disk()->get($path);

		$iblocksCreationFunctionCodeTemplate = static::findInfoblockCreationAndDeletionCodeInInstallFile($file, 'createNecessaryIblocks');
		$iblocksCreationFunctionCode = $module->generateInfoblocksCreationFunctionCode();

		$iblocksDeletionFunctionCodeTemplate = static::findInfoblockCreationAndDeletionCodeInInstallFile($file, 'deleteNecessaryIblocks');
		$iblocksDeletionFunctionCode = $module->generateInfoblocksDeletionFunctionCode();

		$search = [$iblocksCreationFunctionCodeTemplate, $iblocksDeletionFunctionCodeTemplate];
		$replace = [$iblocksCreationFunctionCode, $iblocksDeletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		$module->disk()->put($path, $file);

		static::writeInLangFile($module);

		return true;
	}

	public static function writeInLangFile(Bitrix $module){
		return $module->writeInfoblocksLangInfoInFile();
	}

	protected static function findInfoblockCreationAndDeletionCodeInInstallFile($file, $functionName){
		$beginningCode = "\t".'public function '.$functionName.'(){';
		$beginningPosition = strpos($file, $beginningCode);
		$endingCode = "\t".'} // '.$functionName;
		$endingPosition = strpos($file, $endingCode);
		$codeLength = $endingPosition - $beginningPosition + strlen($endingCode);

		return substr($file, $beginningPosition, $codeLength);
	}

	public function generateCreationCode(){
		$code = '';
		$code .= "\t\t".'$iblockID = $this->createIblock('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t\t".'"IBLOCK_TYPE_ID" => $iblockType,'.PHP_EOL;
		foreach ($this->params as $paramCode => $paramVal){
			if ($paramCode == "NAME"){
				$paramVal = 'Loc::getMessage("'.$this->lang_key.'_NAME")';
			}else{
				if (is_string($paramVal)){
					if (strpos($paramVal, 'Array(') === false){ // todo суперкостыль из-за вложенных массивов
						$paramVal = '"'.$paramVal.'"';
					}
				}else{
					// todo здесь рекурсия должна быть на вложенности
					$paramVal = (array) $paramVal;
					//dd($paramVal);
					$paramValTemp = 'Array(';
					foreach ($paramVal as $paramValCode => $paramValVal){
						$paramValTemp .= '"'.$paramValCode.'"=>"'.$paramValVal.'",';
					}
					$paramValTemp .= ')';
					$paramVal = $paramValTemp;
				}
			}
			$code .= "\t\t\t\t\t".'"'.$paramCode.'"'." => ".''.$paramVal.','.PHP_EOL;
		}
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		$properties = $this->properties()->get();
		foreach ($properties as $property){
			$code .= $property->generateCreationCode();
		}

		return $code;
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
