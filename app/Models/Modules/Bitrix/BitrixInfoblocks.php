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
		$iblocksDeletionFunctionCode = static::generateInfoblocksDeletionFunctionCode($module);

		$search = [$iblocksCreationFunctionCodeTemplate, $iblocksDeletionFunctionCodeTemplate];
		$replace = [$iblocksCreationFunctionCode, $iblocksDeletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		$module->disk()->put($path, $file);

		static::manageHelpersFunctions($module);

		static::writeInLangFile($module);

		return true;
	}

	public static function manageHelpersFunctions($module){
		if ($module->infoblocks()->count()){
			$module->addAdditionalInstallHelpersFunctions(['createIblockType', 'removeIblockType', 'createIblock'], 'iblock.php');
			$issetProp = false;
			$issetElement = false;
			foreach ($module->infoblocks as $infoblock){
				if ($infoblock->properties()->count()){
					$issetProp = true;
				}else{

				}
				if ($infoblock->elements()->count()){
					$issetElement = true;
				}
			}

			if ($issetProp){
				$module->addAdditionalInstallHelpersFunctions(['createIblockProp'], 'iblock.php');
			}else{
				$module->removeAdditionalInstallHelpersFunctions(['createIblockProp']);
			}
			if ($issetElement){
				$module->addAdditionalInstallHelpersFunctions(['createIblockElement'], 'iblock.php');
			}else{
				$module->removeAdditionalInstallHelpersFunctions(['createIblockElement']);
			}

		}else{
			$module->removeAdditionalInstallHelpersFunctions(['createIblockType', 'removeIblockType', 'createIblock', 'createIblockProp', 'createIblockElement']);
		}
	}

	public static function generateInfoblocksCreationFunctionCode($module){
		$code = 'function createNecessaryIblocks(){'.PHP_EOL;
		if ($module->infoblocks()->count()){
			$code .= "\t\t".'$iblockType = $this->createIblockType();'.PHP_EOL;

			foreach ($module->infoblocks as $iblock){
				$code .= $iblock->generateCreationCode();
			}

		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= "\t".'}';

		return $code;
	}

	public static function generateInfoblocksDeletionFunctionCode($module){
		$code = 'function deleteNecessaryIblocks(){'.PHP_EOL;
		if ($module->infoblocks()->count()){
			$code .= "\t"."\t".'$this->removeIblockType();'.PHP_EOL;
		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= "\t".'}';

		return $code;
	}

	public static function writeInLangFile(Bitrix $module){
		foreach ($module->infoblocks as $iblock){
			$module->changeVarInLangFile($iblock->lang_key."_NAME", $iblock->name, '/lang/'.$module->default_lang.'/install/index.php');

			foreach ($iblock->properties as $property){
				$module->changeVarInLangFile($property->lang_key."_NAME", $property->name, '/lang/'.$module->default_lang.'/install/index.php');
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
						$val = implode(',', $val);
					}

					if ($val){
						$module->changeVarInLangFile($element->lang_key.'_PROP_'.$prop->code.'_VALUE', $val, '/lang/'.$module->default_lang.'/install/index.php');
					}
				}
			}
		}

		return true;
	}

	public function generateCreationCode(){
		$code = '';
		$code .= "\t\t".'$iblockID = $this->createIblock('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t".'"IBLOCK_TYPE_ID" => $iblockType,'.PHP_EOL;
		$code .= "\t\t\t\t".'"ACTIVE" => "Y",'.PHP_EOL;
		$code .= "\t\t\t\t".'"LID" => $this->getSitesIdsArray(),'.PHP_EOL;
		// dd($this->params);
		$code .= $this->getParamCodeForCreationArray($this->params, 4);
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		foreach ($this->properties as $property){
			$code .= $property->generateCreationCode();
		}

		foreach ($this->elements as $element){
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
			}else{
				if (is_string($val)){
					if (strpos($val, 'Array(') === false){ // обычные (не массивы) обрамляем запятыми
						$val = '"'.$val.'"';
					}
				}else{
					// dd($val);
					$val = (array)$val;
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
						$val = '"'.$val["TEMPLATE"].$modifiers.'"';
					}else{
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
		$this->module()->first()->changeVarInLangFile($this->lang_key."_NAME", "", '/lang/'.$this->module->default_lang.'/install/index.php');

		foreach ($this->properties as $property){
			$this->module()->first()->changeVarInLangFile($property->lang_key."_NAME", "", '/lang/'.$this->module->default_lang.'/install/index.php');
		}

		foreach ($this->elements as $element){
			$this->module()->first()->changeVarInLangFile($element->lang_key."_NAME", "", '/lang/'.$this->module->default_lang.'/install/index.php');

			foreach ($element->props as $prop){
				$this->module()->first()->changeVarInLangFile($element->lang_key.'_PROP_'.$prop->code.'_VALUE', "", '/lang/'.$this->module->default_lang.'/install/index.php');
			}
		}
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

	public function elements(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksElements', 'iblock_id');
	}
}
