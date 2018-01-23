<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksProps extends Model{
	protected $table = 'bitrix_infoblocks_props';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'type', 'multiple', 'is_required', 'dop_params'];
	public $timestamps = false;
	protected $casts = [
		'dop_params' => 'array',
	];

	public static $types = [
		['label' => "Базовые типы",
		 'code'  => "base_types_group",
		 'props' => [
			 ['code' => "S", 'name' => 'Строка'],
			 ['code' => "N", 'name' => 'Число'],
			 ['code' => "L", 'name' => 'Список'],
			 ['code' => "F", 'name' => 'Файл'],
			 ['code' => "G", 'name' => 'Привязка к разделам'],
			 ['code' => "E", 'name' => 'Привязка к элементам'],
		 ]
		],
		['label' => "Пользовательские типы",
		 'code'  => "user_types_group",
		 'props' => [
			 ['code' => "S:HTML", 'name' => 'HTML/текст'],
			 ['code' => "S:video", 'name' => 'Видео'],
			 ['code' => "S:Date", 'name' => 'Дата'],
			 ['code' => "S:DateTime", 'name' => 'Дата/Время'],
			 ['code' => "S:map_yandex", 'name' => 'Привязка к Яндекс.Карте'],
			 ['code' => "S:map_google", 'name' => 'Привязка к карте Google Maps'],
			 ['code' => "S:UserID", 'name' => 'Привязка к пользователю'],
			 ['code' => "G:SectionAuto", 'name' => 'Привязка к разделам с автозаполнением'],
			 ['code' => "S:TopicID", 'name' => 'Привязка к теме форума'],
			 ['code' => "E:SKU", 'name' => 'Привязка к товарам (SKU)'],
			 ['code' => "S:FileMan", 'name' => 'Привязка к файлу (на сервере)'],
			 ['code' => "E:EList", 'name' => 'Привязка к элементам в виде списка'],
			 ['code' => "S:ElementXmlID", 'name' => 'Привязка к элементам по XML_ID'],
			 ['code' => "E:EAutocomplete", 'name' => 'Привязка к элементам с автозаполнением'],
			 ['code' => "S:directory", 'name' => 'Справочник'],
			 ['code' => "N:Sequence", 'name' => 'Счетчик'],
		 ],
		]
	];

	public function generateCreationCode($startingTabs = 0){
		$type = $this->type;
		$user_type = '';
		if (strpos($this->type, ':')){
			list($type, $user_type) = explode(':', $this->type);
		}
		$code = '';
		$code .= str_repeat("\t", $startingTabs).'$prop'.$this->id.'ID = $this->createIblockProp('.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t".'Array('.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"IBLOCK_ID"'." => ".$this->iblock->php_var_name.','.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"PROPERTY_TYPE"'." => ".'"'.$type.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"USER_TYPE"'." => ".'"'.$user_type.'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"MULTIPLE"'.' => "'.($this->multiple ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs)."\t\t".'"IS_REQUIRED"'." => ".'"'.($this->is_required ? 'Y' : 'N').'",'.PHP_EOL;
		if ($this->dop_params){
			if (isset($this->dop_params["DEFAULT_VALUE"])){
				$code .= str_repeat("\t", $startingTabs)."\t\t".'"DEFAULT_VALUE"'." => ".'Loc::getMessage("'.$this->lang_key.'_DEFAULT_VALUE"),'.PHP_EOL;
			}
			if (isset($this->dop_params["HINT"])){
				$code .= str_repeat("\t", $startingTabs)."\t\t".'"HINT"'." => ".'Loc::getMessage("'.$this->lang_key.'_HINT"),'.PHP_EOL;
			}
			if (isset($this->dop_params["SEARCHABLE"]) && $this->dop_params["SEARCHABLE"] == 'Y'){
				$code .= str_repeat("\t", $startingTabs)."\t\t".'"SEARCHABLE"'." => ".'"Y",'.PHP_EOL;
			}
			if (isset($this->dop_params["LIST_TYPE"])){
				$code .= str_repeat("\t", $startingTabs)."\t\t".'"LIST_TYPE"'." => ".'"'.($this->dop_params["LIST_TYPE"]).'",'.PHP_EOL;
			}
            if (isset($this->dop_params["FILE_TYPE"])){
                $code .= str_repeat("\t", $startingTabs)."\t\t".'"FILE_TYPE"'." => ".'"'.($this->dop_params["FILE_TYPE"]).'",'.PHP_EOL;
            }
            if (isset($this->dop_params["LINK_IBLOCK_ID"])){
                $code .= str_repeat("\t", $startingTabs)."\t\t".'"LINK_IBLOCK_ID" => '.(BitrixInfoblocks::find($this->dop_params["LINK_IBLOCK_ID"])->php_var_name).','.PHP_EOL;
            }
		}
		$code .= str_repeat("\t", $startingTabs)."\t".')'.PHP_EOL;
		$code .= str_repeat("\t", $startingTabs).');'.PHP_EOL;

		if ($this->values()->count()){
			foreach ($this->values as $value){
				$code .= $value->generateCreationCode($startingTabs);
			}
		}

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_PARAM_'.strtoupper($this->id));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}

	public function values(){ // todo заменить на vals для единобразия
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksPropsVals', 'prop_id');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixIblocksPropsVals', 'prop_id');
	}
}