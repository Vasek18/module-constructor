<?php

namespace App\Models\Modules\Bitrix;

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
	// protected $casts = [
	// 	'settings'          => 'array',
	// 	'edit_form_label'   => 'array',
	// 	'list_column_label' => 'array',
	// 	'list_filter_label' => 'array',
	// 	'error_message'     => 'array',
	// ];

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
}
