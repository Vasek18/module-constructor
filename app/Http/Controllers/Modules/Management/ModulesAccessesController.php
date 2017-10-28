<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

                    if (!ModulesAccess::where('user_email', $accessArr['user_email'])->where('module_id', $accessArr['module_id'])->where('permission_code', $accessArr['permission_code'])->count()){
                        $access = ModulesAccess::create($accessArr);

                        // письмо пользователю о предоставлении доступы // todo убрать в обработчик события
                        Mail::send(
                            'emails.modules.management.access_granted',
                            [
                                'user'   => $this->user,
                                'access' => $accessArr,
                                'module' => $module,
                            ],
                            function($m) use ($accessArr){
                                $m->to($accessArr['user_email'])->subject('Предоставлен доступ к модулю');
                            }
                        );
                    }
                }
            }
        }

        return back();
    }

    public function delete(Bitrix $module, ModulesAccess $access, Request $request){
        if (!$this->moduleHasAccess($module, $access)){
            return abort(404);
        }

        $access->delete();

        return back();
    }

    public function moduleHasAccess(Bitrix $module, ModulesAccess $access){
        return $module->id == $access->module_id;
    }
}
