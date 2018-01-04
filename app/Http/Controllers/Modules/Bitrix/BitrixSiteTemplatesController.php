<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Input;
use App\Helpers\vLang;

class BitrixSiteTemplatesController extends Controller{

    use UserOwnModule;

    public function index(Bitrix $module, Request $request){
        $data = [
            'module' => $module,
        ];

        return view("bitrix.site_templates.index", $data);
    }
}