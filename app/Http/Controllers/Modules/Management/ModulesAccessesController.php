<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesAccess;
use Illuminate\Http\Request;

class ModulesAccessesController extends Controller{

    public function index(Bitrix $module, Request $request){
        $data = [
            'accesses'    => ModulesAccess::formatForPage($module->accesses()->get()),
            'module'      => $module,
            'permissions' => ModulesAccess::$permissions,
        ];

        return view("modules_management.accesses.index", $data);
    }

    public function store(Bitrix $module, Request $request){
        foreach ($request->email as $c => $email){
            if (!$email){
                continue;
            }
            if (isset($request->permission[$c])){
                foreach ($request->permission[$c] as $permission){
                    $accessArr = [
                        'user_email'      => $email,
                        'module_id'       => $module->id,
                        'permission_code' => $permission,
                    ];

                    $access = ModulesAccess::firstOrCreate($accessArr);
                }
            }
        }

        return back();
    }

    public function moduleHasAccess(Bitrix $module, ModulesAccess $access){
        return $module->id == $access->module_id;
    }
}
