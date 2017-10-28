<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Modules\Bitrix\Bitrix;

// проверка на владение модулем
class ModuleOwner{

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next){
        $user = $request->user();
        if ($user){ // если нет юзера, то мы не делаем проверки здесь, пусть этим другие middleware занимаются
            $module_id = $request->segment(2);
            if (intval($module_id)){ // если мы на странице какого-то конкретного модуля
                $module = Bitrix::find($module_id);
                if ($module && !$module->ifUserIsOwner($user)){ // если юзер владеет модулем
                    return abort(404);
                }
            }
        }

        return $next($request);
    }
}
