<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Modules\Bitrix\BitrixHelperFunctions;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';
	protected $fillable = ['type', 'module_id', 'sort', 'code', 'name', 'height', 'width', 'spec_vals', 'spec_vals_args', 'default_value'];
	public $timestamps = false;

	public static function getDefaultType(){
		return 'text';
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile(Bitrix $module){
		$optionsString = '';
		$helperFunctionsArr = [];
		$helperFunctions = "";
		Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/'.$module->default_lang.'/options.php', $module->id);
		if ($module->options()->count()){
			$options = $module->options()->orderBy('sort', 'asc')->get();

			foreach ($options as $option){
				$field_params_string = $option->getParamsStringForFile($option->type);
				if ($option->spec_vals){
					$helperFunctionsArr[] = $option->getNeededHelperFunctionName();
				}

				$default_value_string = "''";
				if ($option->default_value){
					$default_value_string = "Loc::getMessage('".$option->lang_key."_DEFAULT_VALUE')";
				}

				//dd($field_params_string);
				// код, название, значение по умолчанию, [тип поля, параметры]
				$string = PHP_EOL."\t\t\tarray('".$option->code."', Loc::getMessage('".$option->lang_key."_TITLE'), ".$default_value_string.", array('".$option->type."'".$field_params_string.")),";
				//echo $string;

				$optionsString .= $string;

				$module->changeVarInLangFile($option->lang_key.'_TITLE', $option->name, 'lang/'.$module->default_lang.'/options.php');
				if ($option->default_value){
					$module->changeVarInLangFile($option->lang_key."_DEFAULT_VALUE", $option->default_value, 'lang/'.$module->default_lang.'/options.php');
				}
				if ($option->type == 'selectbox' || $option->type == 'multiselectbox'){
					if ($option->vals->count()){
						foreach ($option->vals as $val){
							$module->changeVarInLangFile($val->lang_key, $val->value, 'lang/'.$module->default_lang.'/options.php'); // todo, а это всегда надо?
						}
					}
				}
			}

			// dd($helperFunctionsArr);
			$helperFunctions = BitrixHelperFunctions::getPhpCodeFromListOfFuncsNames($module, $helperFunctionsArr);
		}

		Bitrix::changeVarsInModuleFileAndSave('bitrix/options.php', $module->id, Array("{OPTIONS}", "{HELPER_FUNCTIONS}"), Array($optionsString, $helperFunctions));
	}

	public function getNeededHelperFunctionName(){
		if ($this->spec_vals == 'iblocks_list'){
			return 'iblocks_list';
		}
		if ($this->spec_vals == 'iblock_items_list'){
			return 'iblock_items_list';
		}
		if ($this->spec_vals == 'iblock_props_list'){
			return 'iblock_props_list';
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
