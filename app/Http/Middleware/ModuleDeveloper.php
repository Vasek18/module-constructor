<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Modules\Bitrix\Bitrix;

class ModuleDeveloper{

    public function handle($request, Closure $next){
        $user = $request->user();
        if ($user){ // если нет юзера, то мы не делаем проверки здесь, пусть этим другие middleware занимаются
            $module_id = $request->segment(2);
            if (intval($module_id)){ // если мы на странице какого-то конкретного модуля
                $module = Bitrix::find($module_id);
                if ($module){
                    if (!$module->ifUserIsOwner($user) && !$module->ifUserHasPermission($user, 'D')){ // если юзер владеет модулем

                        // todo переделать на abort(404), для этого придётся тесты переписать
                        if ($request->ajax()){
                            return response(['message' => 'Nea'], 403);
                        }
                        return redirect('personal');
                    }
                }
            }
        }

        return $next($request);
    }
}
