<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Metrics\MetricsEventsLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;

class BitrixAdminMenuController extends Controller{

    use UserOwnModule;

    public function index(Bitrix $module, Request $request){
        $admin_menu_pages = $module->adminMenuPages()->get();

        $data = [
            'module'           => $module,
            'admin_menu_pages' => $admin_menu_pages
        ];

        // логируем действие
        MetricsEventsLog::log('Открыт раздел страниц админ. меню', $module);

        return view("bitrix.admin_menu.index", $data);
    }

    public function create(Bitrix $module, Request $request){
        $data = [
            'module'           => $module,
            'parent_menu_vars' => BitrixAdminMenuItems::$parent_menu_vars
        ];

        return view("bitrix.admin_menu.edit_form", $data);
    }

    public function store(Bitrix $module, Requests\AdminPageFormRequest $request){
        $admin_menu_page = BitrixAdminMenuItems::updateOrCreate(
            [
                'module_id' => $module->id,
                'name'      => $request->name,
                'code'      => $request->code,
            ],
            [
                'module_id'   => $module->id,
                'name'        => $request->name,
                'code'        => $request->code,
                'parent_menu' => $request->parent_menu,
                'sort'        => $request->sort,
                'text'        => $request->text ? $request->text : $request->name,
                'php_code'    => $request->php_code ?: BitrixAdminMenuItems::$helloWorldPageCode,
                'lang_code'   => $request->lang_code,
            ]
        );

        // логируем действие
        MetricsEventsLog::log('Создана страница админ. меню', [
            'module'          => $module,
            'admin_menu_page' => $admin_menu_page
        ]);

        BitrixAdminMenuItems::storeInModuleFolder($module);

        return redirect(action('Modules\Bitrix\BitrixAdminMenuController@show', [
            $module->id,
            $admin_menu_page->id
        ]));
    }

    public function show(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Request $request){
        if (!$this->moduleOwnsAdminMenuPage($module, $admin_menu_page)){
            return abort(404);
        }

        $data = [
            'module'           => $module,
            'parent_menu_vars' => BitrixAdminMenuItems::$parent_menu_vars,
            'admin_menu_page'  => $admin_menu_page
        ];

        return view("bitrix.admin_menu.edit_form", $data);
    }

    public function edit($id){
        //
    }

    public function update(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Requests\AdminPageFormRequest $request){
        if (!$this->moduleOwnsAdminMenuPage($module, $admin_menu_page)){
            return abort(404);
        }

        $admin_menu_page->update([
                'name'        => $request->name,
                'code'        => $request->code,
                'parent_menu' => $request->parent_menu,
                'sort'        => $request->sort,
                'text'        => $request->text ? $request->text : $request->name,
                'php_code'    => $request->php_code,
                'lang_code'   => $request->lang_code,
            ]
        );

        // логируем действие
        MetricsEventsLog::log('Обновлена страница админ. меню', [
            'module'          => $module,
            'admin_menu_page' => $admin_menu_page
        ]);

        BitrixAdminMenuItems::storeInModuleFolder($module);

        return redirect(action('Modules\Bitrix\BitrixAdminMenuController@show', [
            $module->id,
            $admin_menu_page->id
        ]));
    }

    public function destroy(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Request $request){
        if (!$this->moduleOwnsAdminMenuPage($module, $admin_menu_page)){
            return abort(404);
        }

        // логируем действие
        MetricsEventsLog::log(
            'Удалена страница админ. меню',
            [
                'module'          => $module,
                'admin_menu_page' => $admin_menu_page
            ]
        );

        $admin_menu_page->delete();

        BitrixAdminMenuItems::storeInModuleFolder($module);

        return redirect(action('Modules\Bitrix\BitrixAdminMenuController@index', [$module->id]));
    }

}