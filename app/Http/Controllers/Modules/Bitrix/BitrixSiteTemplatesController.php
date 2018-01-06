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
            'name' => 'required',
            'code' => 'required',
        ]);

        $template = BitrixSiteTemplate::updateOrCreate(
            [
                'module_id' => $module->id,
                // todo мб можно парсить из архива
                'code'      => trim($request->code)
            ],
            [
                'module_id' => $module->id,
                // todo мб можно парсить из архива
                'name'      => trim($request->name),
                // todo мб можно парсить из архива
                'code'      => trim($request->code),
                'sort'      => intval($request->sort)
            ]
        );

        // todo проверка наличия обязательных файлов
        // todo парсинг шаблона?
        // todo парсинг и проверка тем
        if ($request->file('archive')){
            $archivePath = $this->saveUserUploadToPublic($request->file('archive'));
            $this->extractTemplateToModuleFolder($module, $archivePath);
            //            $componentCode = $this->getComponentCodeFromFolder($fileName);
            unlink($archivePath);
            //            $component->parseTemplates();
        } else{
            $template->writeInFolder($module);
        }

        return redirect(action('Modules\Bitrix\BitrixSiteTemplatesController@show', [
            $module->id,
            $template->id
        ]));
    }

    public function saveUserUploadToPublic($archive){
        $fileName = time().rand(1, 10).$archive->getClientOriginalName();
        $archive->move(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR, $fileName);

        return public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName;
    }

    // todo проверка, что в архиве ровно одна папка - шаблон
    public function extractTemplateToModuleFolder(Bitrix $module, $archivePath){
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