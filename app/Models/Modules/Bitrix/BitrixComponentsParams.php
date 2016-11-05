<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class BitrixComponentsParams extends Model{
	protected $table = 'bitrix_components_params';
	protected $fillable = ['component_id', 'type', 'code', 'name', 'sort', 'group_id', 'refresh', 'default', 'size', 'cols', 'multiple', 'default', 'additional_values', 'spec_vals', 'spec_vals_args', 'template_id'];
	public $timestamps = false;

	public static $systemParams = [
		'CACHE_TIME'           => [
			'ru' => [
				'NAME' => 'Время кеширования (сек.)'
			],
			'en' => [
				'NAME'
			]
		],
		'SEF_MODE'             => [
			'ru' => [
				'NAME' => 'Включить поддержку ЧПУ'
			],
			'en' => [
				'NAME'
			]
		],
		'SEF_RULE'             => [
			'ru' => [
				'NAME' => 'Правило для обработки'
			],
			'en' => [
				'NAME'
			]
		],
		'AJAX_MODE'            => [
			'ru' => [
				'NAME' => 'Включить режим AJAX'
			],
			'en' => [
				'NAME'
			]
		],
		'SECTION_URL'          => [
			'ru' => [
				'NAME' => 'URL, ведущий на страницу с содержимым раздела'
			],
			'en' => [
				'NAME'
			]
		],
		'DETAIL_URL'           => [
			'ru' => [
				'NAME' => 'URL, ведущий на страницу с содержимым элемента раздела'
			],
			'en' => [
				'NAME'
			]
		],
		'SET_TITLE'            => [
			'ru' => [
				'NAME' => 'Устанавливать заголовок страницы'
			],
			'en' => [
				'NAME'
			]
		],
		'SET_META_KEYWORDS'    => [
			'ru' => [
				'NAME' => 'Устанавливать ключевые слова страницы'
			],
			'en' => [
				'NAME'
			]
		],
		'SET_META_DESCRIPTION' => [
			'ru' => [
				'NAME' => 'Устанавливать описание страницы'
			],
			'en' => [
				'NAME'
			]
		],
		'OFFERS_FIELD_CODE'    => [
			'ru' => [
				'NAME'
			],
			'en' => [
				'NAME'
			]
		],
	];

	// public function getNameAttribute($value){
	// 	if (!$value){
	// 		if (isset($this->systemParams->ru->NAME)){
	// 			return $this->systemParams->ru->NAME;
	// 		}
	// 	}
	// 	return $value;
	// }

	public static function getSystemPropName($code){
		// dd($code);
		$systemParams = static::$systemParams;
		$langCode = Config::get('app.locale');
		if (isset($systemParams[$code][$langCode]["NAME"])){
			// dd($systemParams[$code][$langCode]["NAME"]);
			return $systemParams[$code][$langCode]["NAME"];
		}
	}

	public function getNeededHelperFunctionName(){
		if ($this->spec_vals == 'iblocks_types_list'){
			return 'iblocks_types_list';
		}
		if ($this->spec_vals == 'iblocks_list'){
			return 'iblocks_list';
		}
		if ($this->spec_vals == 'iblock_items_list'){
			return 'iblock_items_list';
		}
		if ($this->spec_vals == 'iblock_props_list'){
			return 'iblock_props_list';
		}
		if ($this->spec_vals == 'pager_templates_list'){
			return 'pager_templates_list';
		}
	}

	public function cleanLangFromYourself(){
		$module = $this->component->module;
		$module->changeVarInLangFile($this->lang_key.'_NAME', '', $this->lang_file_path);
		$module->changeVarInLangFile($this->lang_key.'_DEFAULT', '', $this->lang_file_path);
		foreach ($this->vals as $val){
			$module->changeVarInLangFile($val->lang_key.'_VALUE', '', $this->lang_file_path);
		}
	}

	public function getLangFilePathAttribute(){
		if ($this->template_id){
			$template = BitrixComponentsTemplates::find($this->template_id);

			return $template->parameters_lang_file_path;
		}else{
			return $this->component->parameters_lang_file_path;
		}
	}

	public function getSpecValsFunctionCallAttribute(){
		return $this->spec_vals ? "$".$this->spec_vals."(".$this->spec_vals_args.")" : '""';
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->component()->first()->lang_key.'_PARAM_'.$this->code);
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsParamsVals', "param_id");
	}

	public function scopeForAllTemplates($query){
		return $query->where('template_id', null);
	}
}
