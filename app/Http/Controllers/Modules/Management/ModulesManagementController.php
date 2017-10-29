<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Metrics\MetricsEventsLog;
use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;

class ModulesManagementController extends Controller{

    /**
     *
     * @param Bitrix $module
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Bitrix $module, Request $request){
        $data = [
            'module' => $module,
        ];

        // логируем действие
        MetricsEventsLog::log('Открыта главная страница менеджмента модуля', $module);

        return view("modules_management.index", $data);
    }

}