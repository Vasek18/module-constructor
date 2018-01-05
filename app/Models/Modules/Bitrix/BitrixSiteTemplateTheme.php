<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixSiteTemplateTheme extends Model{

    protected $table = 'bitrix_site_template_themes';
    protected $fillable = [
        'template_id',
        'name',
        'sort',
        'code',
        'description',
    ];
    public $timestamps = false;

    public static $defaultName = 'Основная';
    public static $defaultSort = 500;
    public static $defaultCode = 'main';

    public function writeInFolder(){
        $template = $this->template()->first();
        $module   = $template->module()->first();

        $files = [
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/lang/ru/big.png',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/lang/ru/description.php',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/lang/ru/preview.gif',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/lang/ru/screen.gif',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/lang/ru/small.png',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/colors.css',
            'bitrix/install/wizards/partner_code/module_code/site/templates/template_name/themes/theme_name/description.php',
        ];
        foreach ($files as $path){
            Bitrix::changeVarsInModuleFileAndSave(
                $path,
                $module->id,
                [
                    '{THEME_NAME}',
                    '{THEME_DESCRIPTION}',
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
                        'theme_name',
                    ], [
                    $module->PARTNER_CODE,
                    $module->code,
                    $template->code,
                    $this->code,
                ],
                    $path
                )
            );
        }
    }

    public function template(){
        return $this->belongsTo('App\Models\Modules\Bitrix\BitrixSiteTemplate');
    }
}