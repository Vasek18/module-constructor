<?php

namespace App\Models\Modules\Bitrix;

use App\Http\Utilities\Bitrix\BitrixHelperFunctions;
use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';
	protected $fillable = ['type', 'module_id', 'sort', 'code', 'name', 'height', 'width', 'spec_vals', 'spec_vals_args', 'default_value', 'tab'];
	public $timestamps = false;

	public static function getDefaultType(){
		return 'text';
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile(Bitrix $module){
		$optionsString = '';
		$helperFunctionsArr = [];
		$helperFunctions = "";

		$optionsLangFilePath = 'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'options.php';

		Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.$optionsLangFilePath, $module->id);

		if ($module->options()->count()){
			$tabs = $module->options()->orderBy('sort', 'asc')->get()->groupBy('tab');

			foreach ($tabs as $tabName => $options){
				$tabCode = translit($tabName);

				$tabLangKey = $module->lang_key."_TAB_".strtoupper($tabCode);
				$module->changeVarInLangFile($tabLangKey, $tabName, $optionsLangFilePath);

				$optionsString .= "\tArray(
\t\t'DIV'     => '".strtoupper($tabCode)."',
\t\t'TAB'     => Loc::getMessage('".$tabLangKey."'),
\t\t'OPTIONS' => Array(";

				foreach ($options as $option){
					/**
					 * @@var BitrixAdminOptions $option
					 */
					$optionsString .= $option->getPhpCodeString();

					// запоминаем какие нужны доп. функции
					if ($option->spec_vals){
						$helperFunctionsArr[] = $option->getNeededHelperFunctionName();
					}

					$module->changeVarInLangFile($option->lang_key.'_TITLE', $option->name, $optionsLangFilePath);
					if ($option->default_value){
						$module->changeVarInLangFile($option->lang_key."_DEFAULT_VALUE", $option->default_value, $optionsLangFilePath);
					}
					if ($option->type == 'selectbox' || $option->type == 'multiselectbox'){
						if ($option->vals->count()){
							foreach ($option->vals as $val){
								$module->changeVarInLangFile($val->lang_key, $val->value, $optionsLangFilePath); // todo, а это всегда надо?
							}
						}
					}
				}

				$optionsString .= "\t\t),".PHP_EOL."\t),".PHP_EOL;
			}

			$helperFunctions = BitrixHelperFunctions::getPhpCodeFromListOfFuncsNames($helperFunctionsArr);
			$helperFunctions = str_replace(Array('{LANG_KEY}'), Array($module->lang_key), $helperFunctions);
		}

		Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'options.php', $module->id, Array("{OPTIONS}", "{HELPER_FUNCTIONS}"), Array($optionsString, $helperFunctions));
	}

	public function getPhpCodeString(){
		$field_params_string = $this->getParamsStringForFile($this->type);

		$default_value_string = "''";
		if ($this->default_value){
			$default_value_string = "Loc::getMessage('".$this->lang_key."_DEFAULT_VALUE')";
		}

		//dd($field_params_string);
		// код, название, значение по умолчанию, [тип поля, параметры]
		$string = PHP_EOL."\t\t\tarray('".$this->code."', Loc::getMessage('".$this->lang_key."_TITLE'), ".$default_value_string.", array('".$this->type."'".$field_params_string.")),";

		return $string;
	}

	public function getNeededHelperFunctionName(){
	    if ($this->spec_vals){
	        return $this->spec_vals;
        }
	}

	public function getParamsStringForFile($option_type){
		$params_string = ', ';
		if ($option_type == "text"){
			// параметры text - ширина
			$params_string .= $this->width;
		}
		if ($option_type == "textarea"){
			// параметры textarea - высота и ширина
			$params_string .= $this->height.', '.$this->width;
		}
		if ($option_type == "checkbox"){
			$params_string .= '"'.$this->spec_vals_args.'"';
		}
		if ($option_type == "selectbox" || $option_type == "multiselectbox"){
			if (!$this->spec_vals || $this->spec_vals == 'array'){
				$params_string .= $this->getValsArrayStringForFile();
			}else{
				//dd($this->spec_vals);
				if ($this->spec_vals == 'iblocks_list'){
					$params_string .= '$iblocks_list('.$this->spec_vals_args.')';
				}
				if ($this->spec_vals == 'iblock_items_list'){
					$params_string .= '$iblock_items_list('.$this->spec_vals_args.')';
				}
                if ($this->spec_vals == 'iblock_sections_list'){
                    $params_string .= '$iblock_sections_list('.$this->spec_vals_args.')';
                }
                if ($this->spec_vals == 'iblock_props_list'){
                    $params_string .= '$iblock_props_list('.$this->spec_vals_args.')';
                }
			}
		}

		return $params_string;
	}

	public function getValsArrayStringForFile(){
		$vals = $this->vals()->get();

		$string = 'Array(';
		foreach ($vals as $val){
			$string .= "'".$val->key."' => Loc::getMessage('".$val->lang_key."'), ";
		}
		$string .= ')';

		return $string;
	}

	public function deleteProps(){
		BitrixAdminOptionsVals::where('option_id', $this->id)->delete();
	}

	public function getLangKeyAttribute(){
		return $this->module->lang_key.'_OPTION_'.strtoupper($this->code);
	}

	public function getBitrixReceiveCodeAttribute(){
		return 'COption::GetOptionString("'.$this->module->full_id.'", "'.$this->code.'")';
	}

	// связи с другими моделями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixAdminOptionsVals', "option_id");
	}
}
