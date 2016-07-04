<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\vFuncParse;

class BitrixAdminMenuItems extends Model{
	protected $table = 'bitrix_admin_menu_pages_items';
	protected $fillable = ['module_id', 'module_id', 'name', "code", 'sort', "parent_menu", "icon", "page_icon", "text", "title", "php_code", "lang_code"];
	public $timestamps = false;

	public static $parent_menu_vars = ['global_menu_services', 'global_menu_settings'];

	public static function storeInModuleFolder(Bitrix $module){
		// сначала чистим от всего, что было раньше
		$module->disk()->deleteDirectory($module->module_folder.'/admin/');

		$menuFilePath = '/admin/menu.php';
		if ($module->adminMenuPages()->count()){
			Bitrix::changeVarsInModuleFileAndSave('bitrix'.$menuFilePath, $module->id); // подготавливаем файл
			$funcName = 'global_menu_'.$module->class_name;

			// подготавливаем функцию для обработчика меню
			$menuArrString = 'function global_menu_aristov_vregions(&$aGlobalMenu, &$aModuleMenu){'.PHP_EOL;
			foreach ($module->adminMenuPages()->get() as $admin_menu_page){
				// подготавливаем строчки с массивами
				$menuArrString .= "\t".'$aModuleMenu[] = array('.PHP_EOL;
				$menuArrString .= "\t"."\t".'"parent_menu" => "'.$admin_menu_page->parent_menu.'",'.PHP_EOL;
				$menuArrString .= "\t"."\t".'"icon"        => "'.($admin_menu_page->icon ? $admin_menu_page->icon : 'default_menu_icon').'",'.PHP_EOL;
				$menuArrString .= "\t"."\t".'"page_icon"   => "'.($admin_menu_page->page_icon ? $admin_menu_page->page_icon : 'default_page_icon').'",'.PHP_EOL;
				$menuArrString .= "\t"."\t".'"text"        => Loc::getMessage("'.$admin_menu_page->lang_key.'_TEXT"),'.PHP_EOL;
				$menuArrString .= "\t"."\t".'"title"       => Loc::getMessage("'.$admin_menu_page->lang_key.'_TITLE"),'.PHP_EOL;
				$menuArrString .= "\t"."\t".'"url"         => "'.$admin_menu_page->file_name.'?lang=".LANGUAGE_ID,'.PHP_EOL;
				$menuArrString .= "\t".');';

				// сохраняем файл с кодом страницы
				$module->disk()->put($module->module_folder.'/admin/'.$admin_menu_page->file_name, $admin_menu_page->php_code);
			}
			$menuArrString .= '}';

			// заменяем функцию в файле на нашу с актуальными массивами
			$file = $module->disk()->get($module->module_folder.$menuFilePath);
			$funcForReplace = vFuncParse::parseFromFile($module->getFolder(true).$menuFilePath, $funcName);
			$file = str_replace($funcForReplace, $menuArrString, $file);
			$module->disk()->put($module->module_folder.$menuFilePath, $file);
		}

		static::writeLangs($module);
	}

	public static function writeLangs(Bitrix $module){
		// сначала чистим от всего, что было раньше
		$module->disk()->deleteDirectory($module->module_folder.'/lang/ru/admin/');

		foreach ($module->adminMenuPages()->get() as $admin_menu_page){
			$module->changeVarInLangFile($admin_menu_page->lang_key."_TEXT", $admin_menu_page->text, '/lang/ru/admin/menu.php');
			$module->changeVarInLangFile($admin_menu_page->lang_key."_TITLE", $admin_menu_page->title ? $admin_menu_page->title : $admin_menu_page->text, '/lang/ru/admin/menu.php');

			// сохраняем файл с лангом страницы
			$module->disk()->put($module->module_folder.'/lang/ru/admin/'.$admin_menu_page->file_name, $admin_menu_page->lang_code);
		}
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->lang_key.'_ADMIN_MENU_'.strtoupper($this->code));
	}

	public function getFileNameAttribute(){
		return $this->module()->first()->class_name.'_'.$this->code.'.php';
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
