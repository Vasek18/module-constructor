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
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/description.php',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/preview.gif',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/lang/ru/screen.gif',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/common.css',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/description.php',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/favicon.ico',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/footer.php',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/header.php',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/styles.css',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/template_styles.css',
        ];
        foreach ($files as $path){
            Bitrix::changeVarsInModuleFileAndSave(
                $path,
                $module->id,
                [
                    '{TEMPLATE_NAME}',
                    '{TEMPLATE_DESCRIPTION}',
                ],
                [
                    $this->name,
                    $this->description,
                ],
                str_replace(
                    [
                        'partner_code',
                        'module_code',
                        'template_name',
                    ], [
                    $module->PARTNER_CODE,
                    $module->code,
                    $this->code,
                ],
                    $path
                )
            );
        }
    }

    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

    public function themes(){
        return $this->hasMany('App\Models\Modules\Bitrix\BitrixSiteTemplateTheme', 'template_id');
    }
}