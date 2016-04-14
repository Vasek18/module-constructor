<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';
	protected $fillable = ['type_id', 'sort', 'code', 'name', 'height', 'width', 'spec_vals', 'spec_vals_args'];

	public static function store(Bitrix $module, $fields){
		//dd($fields);
		if (isset($fields['spec_vals'])){
			if ($fields['spec_vals'] == 'iblocks_list'){
				$fields['spec_vals'] = '$iblocks()';
			}
			if ($fields['spec_vals'] == 'iblock_items_list'){
				$fields['spec_vals'] = '$iblock_items()';
			}
			if ($fields['spec_vals'] == 'iblock_props_list'){
				$fields['spec_vals'] = '$iblock_props()';
			}
		}
		if (!isset($fields['type_id'])){
			$fields['type_id'] = BitrixAdminOptions::getDefaultTypeId();
		}
		if (!DB::table('bitrix_modules_options_types')->where('id', $fields['type_id'])->first()){
			$fields['type_id'] = BitrixAdminOptions::getDefaultTypeId();
		}
		if (!$module->ownedBy(Auth::user())){
			return false;
		}
		if (!isset($fields['code'])){
			return false;
		}
		if (!isset($fields['name'])){
			return false;
		}

		$option = new BitrixAdminOptions($fields);

		if ($module->options()->save($option)){
			return $option;
		}

		return false;
	}

	public static function getDefaultTypeId(){
		$stringType = DB::table('bitrix_modules_options_types')->where('FORM_TYPE', 'text')->first();
		if ($stringType && $stringType->id){
			return $stringType->id;
		}

		return 0;
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile($module_id){
		if (BitrixAdminOptions::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);
			$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);

			$options = BitrixAdminOptions::where('module_id', $module_id)->orderBy('sort', 'asc')->get();
			$optionsString = '';
			$optionsLangString = '';

			// получаем типы полей
			$dboptionsTypes = DB::table('bitrix_modules_options_types')->get(); // приводим к типу, где ключом выступает id, чтобы получать инфу по идентификатору типа // todo скорее всего есть способ легче всё это получать
			$optionsTypes = [];
			foreach ($dboptionsTypes as $option){
				$optionsTypes[$option->id] = $option;
			}

			foreach ($options as $option){
				$option_type = $optionsTypes[$option->type_id]->FORM_TYPE;

				$field_params_in_string = '';
				if ($option_type == "text"){
					// параметры text - ширина
					$field_params_in_string = ', '.$option->width;
				}
				if ($option_type == "textarea"){
					// параметры textarea - высота и ширина
					$field_params_in_string = ', '.$option->height.', '.$option->width;
				}
				if ($option_type == "checkbox"){
					$field_params_in_string = ', "'.$option->spec_vals_args.'"';
				}
				if ($option_type == "selectbox" || $option_type == "multiselectbox"){
					if (!$option->spec_vals || $option->spec_vals == 'array'){
						$vals = BitrixAdminOptionsVals::where('option_id', $option->id)->get();
						if (count($vals)){
							$field_params_in_string = ', Array(';
							foreach ($vals as $val){
								$field_params_in_string .= "'".$val->key."' => '".$val->value."', ";
							}
							$field_params_in_string .= ')';
						}
					}else{
						$field_params_in_string = ', '.str_replace('()', '('.$option->spec_vals_args.')', $option->spec_vals);
					}
				}

				// код, название, значение по умолчанию, [тип поля, параметры]
				$string = PHP_EOL."\t\t\tarray('".$option->code."', Loc::getMessage('".$LANG_KEY."_".strtoupper($option->code)."_TITLE'), '', array('".$option_type."'".$field_params_in_string.")),";
				//echo $string;

				$optionsString .= $string;

				$optionsLangString .= '$MESS["'.$LANG_KEY.'_'.strtoupper($option->code).'_TITLE"] = "'.$option->name.'";'.PHP_EOL;
			}

			Bitrix::changeVarsInModuleFileAndSave('bitrix/options.php', $module_id, Array("{OPTIONS}"), Array($optionsString));
			Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/options.php', $module_id, Array("{OPTIONS_LANG}"), Array($optionsLangString));
		}
	}

	// связи с другими моделями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\BitrixAdminOptionsVals', "option_id");
	}
}
