<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixDataStorageController extends Controller{

    use UserOwnModule;

    // страница настроек для страницы настроек
    public function index(Bitrix $module, Request $request){
        if (!$this->userCreatedModule($module->id)){
            return $this->unauthorized($request);
        }

        $data = [
            'module'      => $module,
            'infoblocks'  => $module->infoblocks()->sorted()->get(),
            'user_fields' => $module->user_fields()->get(),
        ];

        return view("bitrix.data_storage.index", $data);
    }
}