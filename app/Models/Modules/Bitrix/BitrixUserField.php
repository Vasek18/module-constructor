<?php

namespace App\Models\Modules\Bitrix;

use App\Helpers\PhpCodeGeneration;
use Illuminate\Database\Eloquent\Model;

class BitrixUserField extends Model{

	protected $table = 'bitrix_user_fields';

	protected $fillable = [
		'id',
		'module_id',
		'user_type_id',
		'entity_id',
		'field_name',
		'xml_id',
		'sort',
		'multiple',
		'mandatory',
		'show_filter',
		'show_in_list',
		'edit_in_list',
		'is_searchable',
		'settings',
		'edit_form_label',
		'list_column_label',
		'list_filter_label',
		'error_message',
		'help_message',
	];

	public $timestamps = false;

	public static $types = [
		'string' => [
			'name' => 'Строка',
			'code' => 'string'
		],
		// 'video'            => [
		// 	'name' => 'Видео',
		// 	'code' => 'video'
		// ],
		// 'hlblock'          => [
		// 	'name' => 'Привязка к элементам highload-блоков',
		// 	'code' => 'hlblock'
		// ],
		// 'integer'          => [
		// 	'name' => 'Целое число',
		// 	'code' => 'integer'
		// ],
		// 'double'           => [
		// 	'name' => 'Число',
		// 	'code' => 'double'
		// ],
		// 'datetime'         => [
		// 	'name' => 'Дата со временем',
		// 	'code' => 'datetime'
		// ],
		// 'date'             => [
		// 	'name' => 'Дата',
		// 	'code' => 'date'
		// ],
		// 'boolean'          => [
		// 	'name' => 'Да/Нет',
		// 	'code' => 'boolean'
		// ],
		// 'file'             => [
		// 	'name' => 'Файл',
		// 	'code' => 'file'
		// ],
		// 'enumeration'      => [
		// 	'name' => 'Список',
		// 	'code' => 'enumeration'
		// ],
		// 'iblock_section'   => [
		// 	'name' => 'Привязка к разделам инф. блоков',
		// 	'code' => 'iblock_section'
		// ],
		// 'iblock_element'   => [
		// 	'name' => 'Привязка к элементам инф. блоков',
		// 	'code' => 'iblock_element'
		// ],
		// 'string_formatted' => [
		// 	'name' => 'Шаблон',
		// 	'code' => 'string_formatted'
		// ],
		// 'vote'             => [
		// 	'name' => 'Опрос',
		// 	'code' => 'vote'
		// ],
		// 'url_preview'      => [
		// 	'name' => 'Содержимое ссылки',
		// 	'code'  => 'url_preview'
		// ]
	];

	public static $creationFunctionName = 'createNecessaryUserFields';
	public static $deletionFunctionName = 'deleteNecessaryUserFields';
	public static $helperFunctionsFileName = 'user_fields.php';
	public static $creationHelperFunctionName = 'createUserField';
	public static $deletionHelperFunctionName = 'removeUserField';

	public static function writeInFile(Bitrix $module){
		$module->changeInstallFileFunctionCode(static::$creationFunctionName, static::generateCreationFunctionCode($module));
		$module->changeInstallFileFunctionCode(static::$deletionFunctionName, static::generateDeletionFunctionCode($module));

		static::manageHelpersFunctions($module);

		static::writeInLangFile($module);

		return true;
	}

	public static function generateCreationFunctionCode(Bitrix $module){
		$code = 'function '.static::$creationFunctionName.'(){'.PHP_EOL;
		if ($module->user_fields()->count()){
			foreach ($module->user_fields as $user_field){
				$code .= "\t"."\t".$user_field->generateCreationCode();
			}

		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= '}';

		return $code;
	}

	public static function generateDeletionFunctionCode(Bitrix $module){
		$code = 'function '.static::$deletionFunctionName.'(){'.PHP_EOL;
		if ($module->user_fields()->count()){
			foreach ($module->user_fields as $user_fields){
				$code .= "\t\t".$user_fields->generateDeletionCode().PHP_EOL;
			}
		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= "\t".'}';

		return $code;
	}

	public function generateCreationCode(){
		$code = '$this->'.static::$creationHelperFunctionName.'('.PHP_EOL.
			$this->getCreationParamsArrayCode(3).PHP_EOL.
			"\t"."\t".');'.PHP_EOL;

		return $code;
	}

	public function generateDeletionCode(){
		$code = '$this->'.static::$deletionHelperFunctionName.'("'.$this->code.'");';

		return $code;
	}

	public function getCreationParamsArrayCode($tabsCount = 0){
		$params = [
			'USER_TYPE_ID'      => $this->user_type_id,
			'ENTITY_ID'         => $this->entity_id,
			'FIELD_NAME'        => $this->field_name,
			'XML_ID'            => $this->xml_id,
			'SORT'              => $this->sort,
			'MULTIPLE'          => $this->multiple,
			'MANDATORY'         => $this->mandatory,
			'SHOW_FILTER'       => $this->show_filter,
			'SHOW_IN_LIST'      => $this->show_in_list,
			'EDIT_IN_LIST'      => $this->edit_in_list,
			'IS_SEARCHABLE'     => $this->is_searchable,
			'SETTINGS'          => $this->settings,
			'EDIT_FORM_LABEL'   => [
				'ru' => 'Loc::getMessage('.$this->lang_key.'_EDIT_FORM_LABEL)',
			],
			'LIST_COLUMN_LABEL' => [
				'ru' => 'Loc::getMessage('.$this->lang_key.'_LIST_COLUMN_LABEL)',
			],
			'LIST_FILTER_LABEL' => [
				'ru' => 'Loc::getMessage('.$this->lang_key.'_LIST_FILTER_LABEL)',
			],
			'ERROR_MESSAGE'     => [
				'ru' => 'Loc::getMessage('.$this->lang_key.'_ERROR_MESSAGE)',
			],
			'HELP_MESSAGE'      => [
				'ru' => 'Loc::getMessage('.$this->lang_key.'_HELP_MESSAGE)',
			],
		];

		return PhpCodeGeneration::makeArrayCode($params, $tabsCount, '');
	}

	public static function manageHelpersFunctions(Bitrix $module){
		if ($module->user_fields()->count()){
			$module->addAdditionalInstallHelpersFunctions([static::$creationHelperFunctionName, static::$deletionHelperFunctionName], static::$helperFunctionsFileName);
		}else{
			$module->removeAdditionalInstallHelpersFunctions([static::$creationHelperFunctionName, static::$deletionHelperFunctionName]);
		}
	}

	// todo
	public static function writeInLangFile(Bitrix $module){

	}

	// todo
	public function cleanLangFromYourself(){

	}

	// доп. атрибуты
	// запись
	public function setSettingsAttribute($value){
		$this->attributes['settings'] = is_array($value) ? json_encode($value) : $value;
	}

	public function setEditFormLabelAttribute($value){
		$this->attributes['edit_form_label'] = is_array($value) ? json_encode($value) : $value;
	}

	public function setListColumnEditAttribute($value){
		$this->attributes['list_column_label'] = is_array($value) ? json_encode($value) : $value;
	}

	public function setListFilterLabelAttribute($value){
		$this->attributes['list_filter_label'] = is_array($value) ? json_encode($value) : $value;
	}

	public function setErrorMessageAttribute($value){
		$this->attributes['error_message'] = is_array($value) ? json_encode($value) : $value;
	}

	// получение
	public function getSettingsAttribute($value){
		return (array)json_decode($value);
	}

	public function getEditFormLabelAttribute($value){
		return (array)json_decode($value);
	}

	public function getListColumnLabelAttribute($value){
		return (array)json_decode($value);
	}

	public function getListFilterLabelAttribute($value){
		return (array)json_decode($value);
	}

	public function getErrorMessageAttribute($value){
		return (array)json_decode($value);
	}

	public function getHelpMessageAttribute($value){
		return (array)json_decode($value);
	}

	public function getCodeAttribute($value){
		return $this->field_name;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->lang_key.'_USER_FIELD_'.strtoupper($this->code));
	}

	// связи с другими модулями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}
}
