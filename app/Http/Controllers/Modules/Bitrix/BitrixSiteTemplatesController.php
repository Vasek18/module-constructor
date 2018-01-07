<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Http\Controllers\Controller;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixSiteTemplate;
use App\Models\Modules\Bitrix\Bitrix;

class BitrixSiteTemplatesController extends Controller{

    use UserOwnModule;

    public function index(Bitrix $module, Request $request){
        $data = [
            'module'    => $module,
            'templates' => $module->templates()->get()
        ];

        return view("bitrix.site_templates.index", $data);
    }

    public function create(Bitrix $module, Request $request){
        $data = [
            'module' => $module,
        ];

        return view("bitrix.site_templates.create", $data);
    }

    public function store(Bitrix $module, Request $request){
        $this->validate($request, [
            'name'    => 'required',
            'archive' => 'required',
        ]);

        $archivePath = $this->saveUserUploadToPublic($request->file('archive'));

        $templateCode = $this->getTemplateCode($archivePath);
        if (!$templateCode){
            unlink($archivePath);

            return back()->withErrors('Архив не соответствует требованиям');
        }

        /** @var BitrixSiteTemplate $template */
        $template = BitrixSiteTemplate::updateOrCreate(
            [
                'module_id' => $module->id,
                'code'      => $templateCode
            ],
            [
                'module_id'   => $module->id,
                'name'        => trim($request->name),
                'description' => trim($request->description),
                'code'        => $templateCode,
                'sort'        => intval($request->sort)
            ]
        );

        $this->extractTemplateToModuleFolder($module, $archivePath, $template);
        unlink($archivePath);

        if (!$template->parseThemes()){
            $template->createTheme();
        }

        $template->writeInFolder();

        return redirect(action('Modules\Bitrix\BitrixSiteTemplatesController@show', [
            $module->id,
            $template->id
        ]));
    }

    // получаем код шаблона (это родительская папка) и заодно проверяем, что в архиве только шаблон
    public function getTemplateCode($archivePath){
        $zipper = new Zipper;
        $zipper->make($archivePath);

        $templateCode = '';
        foreach ($zipper->listFiles() as $file){
            $pathArr              = explode('/', $file);
            $possibleTemplateCode = $pathArr[0];

            if (!$templateCode){
                $templateCode = $possibleTemplateCode;
            } else{
                if ($templateCode != $possibleTemplateCode){
                    return false; // в архиве больше одной папки в корне или есть файлы на нижнем уровне
                }
            }
        }

        return $templateCode;
    }

    public function saveUserUploadToPublic($archive){
        $fileName = time().rand(1, 10).$archive->getClientOriginalName();
        $archive->move(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR, $fileName);

        return public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName;
    }

    public function extractTemplateToModuleFolder(Bitrix $module, $archivePath, BitrixSiteTemplate $template){
        // если вдруг папки для шаблонов нет => создаём её
        $relativePath = DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'wizards'.DIRECTORY_SEPARATOR.$module->PARTNER_CODE.DIRECTORY_SEPARATOR.$module->code.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'templates';
        $module->disk()->makeDirectory($module->module_full_id.$relativePath);

        $zipper = new Zipper;
        $zipper->make($archivePath);
        $zipper->extractTo($module->getFolder().$relativePath);

        return true;
    }

    public function show(Bitrix $module, BitrixSiteTemplate $template, Request $request){
        if (!$this->moduleOwnsSiteTemplate($module, $template)){
            return $this->unauthorized($request);
        }

        $data = [
            'module'   => $module,
            'template' => $template,
        ];

        return view("bitrix.site_templates.detail", $data);
    }

    public function destroy(Bitrix $module, BitrixSiteTemplate $template, Request $request){
        if (!$this->moduleOwnsSiteTemplate($module, $template)){
            return $this->unauthorized($request);
        }

        $template->delete();

        $template->deleteFolder();

        return redirect(route('bitrix_module_templates', $module->id));
    }
}