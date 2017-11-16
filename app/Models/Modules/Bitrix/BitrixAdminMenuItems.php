<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\vFuncParse;

class BitrixAdminMenuItems extends Model{

    protected $table = 'bitrix_admin_menu_pages_items';
    protected $fillable = [
        'module_id',
        'module_id',
        'name',
        "code",
        'sort',
        "parent_menu",
        "icon",
        "page_icon",
        "text",
        "title",
        "php_code",
        "lang_code"
    ];
    public $timestamps = false;

    public static $parent_menu_vars = [
        'global_menu_store',
        'global_menu_services',
        'global_menu_settings'
    ];

    public static $helloWorldPageCode = '<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $USER, $APPLICATION, $DB;

$APPLICATION->SetTitle(Loc::getMessage("TITLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); ?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php"); ?>';

    public static function storeInModuleFolder(Bitrix $module){
        // сначала чистим от всего, что было раньше
        $module->disk()->deleteDirectory($module->module_folder.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR);

        $menuFilePath = DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'menu.php';

        if ($module->adminMenuPages()->count()){
            Bitrix::changeVarsInModuleFileAndSave('bitrix'.$menuFilePath, $module->id); // подготавливаем файл
            $funcName = 'global_menu_'.$module->class_name;

            // подготавливаем функцию для обработчика меню
            $menuArrString = 'function global_menu_'.$module->class_name.'(&$aGlobalMenu, &$aModuleMenu){'.PHP_EOL;
            foreach ($module->adminMenuPages()->get() as $admin_menu_page){
                // подготавливаем строчки с массивами
                $menuArrString .= "\t".'$aModuleMenu[] = array('.PHP_EOL;
                $menuArrString .= "\t"."\t".'"parent_menu" => "'.$admin_menu_page->parent_menu.'",'.PHP_EOL;
                $menuArrString .= "\t"."\t".'"icon"        => "'.($admin_menu_page->icon ? $admin_menu_page->icon : 'default_menu_icon').'",'.PHP_EOL;
                $menuArrString .= "\t"."\t".'"page_icon"   => "'.($admin_menu_page->page_icon ? $admin_menu_page->page_icon : 'default_page_icon').'",'.PHP_EOL;
                $menuArrString .= "\t"."\t".'"text"        => Loc::getMessage("'.$admin_menu_page->lang_key.'_TEXT"),'.PHP_EOL;
                $menuArrString .= "\t"."\t".'"title"       => Loc::getMessage("'.$admin_menu_page->lang_key.'_TITLE"),'.PHP_EOL;
                $menuArrString .= "\t"."\t".'"url"         => "'.$admin_menu_page->file_name.'",'.PHP_EOL;
                $menuArrString .= "\t".');'.PHP_EOL.PHP_EOL;

                $admin_menu_page->putAdminPageInModule();
            }
            $menuArrString .= '}';

            // заменяем функцию в файле на нашу с актуальными массивами
            $file           = $module->disk()->get($module->module_folder.$menuFilePath);
            $funcForReplace = vFuncParse::parseFromFile($module->getFolder(true).$menuFilePath, $funcName);
            $file           = str_replace($funcForReplace, $menuArrString, $file);
            $module->disk()->put($module->module_folder.$menuFilePath, $file);
        }

        static::writeLangs($module);
    }

    public function putAdminPageInModule(){
        $php_code = $this->php_code;
        if (!$php_code){
            $php_code = static::$helloWorldPageCode;
        }

        $this->module->disk()->put($this->file_path, $php_code);
    }

    public static function writeLangs(Bitrix $module){
        // сначала чистим от всего, что было раньше
        $module->disk()->deleteDirectory($module->module_folder.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR);

        foreach ($module->adminMenuPages()->get() as $admin_menu_page){
            $module->changeVarInLangFile($admin_menu_page->lang_key."_TEXT", $admin_menu_page->text, DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'menu.php');
            $module->changeVarInLangFile($admin_menu_page->lang_key."_TITLE", $admin_menu_page->title ? $admin_menu_page->title : $admin_menu_page->text, DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'menu.php');

            // сохраняем файл с лангом страницы
            if (!$admin_menu_page->lang_code){
                $admin_menu_page->update(['lang_code' => $admin_menu_page->generateLangPage()]);
            }
            $module->disk()->put($admin_menu_page->lang_file_path, $admin_menu_page->lang_code);
        }
    }

    public function generateLangPage(){
        $file = '<?'.PHP_EOL;
        if ($this->name){
            $file .= '$MESS["TITLE"] = "'.$this->name.'";'.PHP_EOL;
        }

        return $file;
    }

    public function getLangKeyAttribute(){
        return strtoupper($this->module()->first()->lang_key.'_ADMIN_MENU_'.strtoupper($this->code));
    }

    public function getFilePathAttribute(){
        return $this->module->module_folder.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.$this->file_name;
    }

    public function getLangFilePathAttribute(){
        return $this->module->module_folder.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$this->module->default_lang.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.$this->file_name;
    }

    public function getFileNameAttribute(){
        return $this->module()->first()->class_name.'_'.$this->code.'.php';
    }

    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

}
