<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixAdminMenuItems extends Model{
	protected $table = 'bitrix_admin_menu_pages_items';
	protected $fillable = ['module_id', 'module_id', 'name', "code", 'sort', "parent_menu", "icon", "page_icon", "text", "title", "php_code"];
	public $timestamps = false;

	public static $parent_menu_vars = ['global_menu_services', 'global_menu_settings'];

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
