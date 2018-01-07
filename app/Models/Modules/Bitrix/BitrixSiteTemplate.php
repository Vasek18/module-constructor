<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixSiteTemplate extends Model{

    protected $table = 'bitrix_site_templates';
    protected $fillable = [
        'module_id',
        'name',
        'sort',
        'code',
        'description',
    ];
    public $timestamps = false;

    public static $defaultName = 'Главный';
    public static $defaultSort = 500;
    public static $defaultCode = 'main';

    public function writeInFolder(){
        /** @var Bitrix $module */
        $module       = $this->module()->first();
        $moduleFolder = $module->getFolder(false);

        $files = [
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/description.php',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/description.php',
                'test_existence' => false
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/preview.gif',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/preview.gif',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/screen.gif',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/screen.gif',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/description.php',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/description.php',
                'test_existence' => false
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/favicon.ico',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/favicon.ico',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/footer.php',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/footer.php',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/header.php',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/header.php',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/styles.css',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/styles.css',
                'test_existence' => true
            ],
            [
                'in'             => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/template_styles.css',
                'out'            => $moduleFolder.'/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/template_styles.css',
                'test_existence' => true
            ],
        ];
        foreach ($files as $file){
            if ($file['test_existence'] && $module->disk()->exists($file['out'])){
                continue;
            }
            Bitrix::changeVarsInModuleFileAndSave(
                $file['in'],
                $module->id,
                [
                    '{TEMPLATE_NAME}',
                    '{TEMPLATE_DESCRIPTION}',
                    '{TEMPLATE_SORT}',
                ],
                [
                    $this->name,
                    $this->description,
                    $this->sort,
                ],
                $file['out']
            );
        }
    }

    public function getFolder($full = false){
        $module        = $this->module()->first();
        $module_folder = $module->getFolder($full);

        return $module_folder.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'wizards'.DIRECTORY_SEPARATOR.$module->PARTNER_CODE.DIRECTORY_SEPARATOR.$module->code.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->code;
    }

    public function createFolder(){
        $this->module()->first()->disk()->makeDirectory($this->getFolder());
    }

    public function deleteFolder(){
        $this->module()->first()->disk()->deleteDirectory($this->getFolder());
    }

    // todo
    public function parseThemes(){

    }

    // todo
    public function createTheme(){

    }

    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

    public function themes(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixSiteTemplateTheme', 'template_id');
    }
}