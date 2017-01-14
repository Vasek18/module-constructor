<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixComponentClassPhpTemplates extends Model{
	protected $table = 'bitrix_components_class_php_templates';
	protected $fillable = ['creator_id', 'name', 'template', 'show_everyone', 'need_edit'];
}