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
        $module = $this->module()->first();

        $files = [
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/description.php',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/description.php'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/preview.gif',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/preview.gif'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/screen.gif',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/lang/ru/screen.gif'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/common.css',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/common.css'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/description.php',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/description.php'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/favicon.ico',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/favicon.ico'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/footer.php',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/footer.php'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/header.php',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/header.php'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/styles.css',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/styles.css'
            ],
            [
                'in'  => 'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/template_styles.css',
                'out' => 'bitrix/install/wizards/'.$module->PARTNER_CODE.'/'.$module->code.'/site/templates/'.$this->code.'/template_styles.css'
            ],
        ];
        foreach ($files as $file){
            Bitrix::changeVarsInModuleFileAndSave(
                $file['in'],
                $module->id,
                [
                    '{TEMPLATE_NAME}',
                    '{TEMPLATE_DESCRIPTION}',
                ],
                [
                    $this->name,
                    $this->description,
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

    public function deleteFolder(){
        $this->module()->first()->disk()->deleteDirectory($this->getFolder());
    }

    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

    public function themes(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixSiteTemplateTheme', 'template_id');
    }
}