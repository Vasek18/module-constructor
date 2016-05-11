<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixIblocksProps extends Model{
	protected $table = 'bitrix_infoblocks_props';
	protected $fillable = ['iblock_id', 'name', 'code', 'sort', 'type', 'multiple', 'is_required'];
	public $timestamps = false;

	public static $types = [
		['label' => "Базовые типы",
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

	public function generateCreationCode(){
		$type = $this->type;
		$user_type = '';
		if (strpos($this->type, ':')){
			list($type, $user_type) = explode(':', $this->type);
		}
		$code = '';
		$code .= "\t\t".'$this->createIblockProp('.PHP_EOL;
		$code .= "\t\t\t".'Array('.PHP_EOL;
		$code .= "\t\t\t\t\t".'"IBLOCK_ID"'." => ".'$iblockID,'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"ACTIVE"'." => ".'"Y",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"SORT"'." => ".'"'.$this->sort.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"CODE"'." => ".'"'.$this->code.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"NAME"'." => ".'Loc::getMessage("'.$this->lang_key.'_NAME"),'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"PROPERTY_TYPE"'." => ".'"'.$type.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"USER_TYPE"'." => ".'"'.$user_type.'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"MULTIPLE"'." => ".'"'.($this->multiple ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= "\t\t\t\t\t".'"IS_REQUIRED"'." => ".'"'.($this->is_required ? 'Y' : 'N').'",'.PHP_EOL;
		$code .= "\t\t\t".')'.PHP_EOL;
		$code .= "\t\t".');'.PHP_EOL;

		return $code;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->iblock()->first()->lang_key.'_PARAM_'.strtoupper($this->code));
	}

	public function iblock(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixInfoblocks');
	}
}