<?php

namespace App\Http\Controllers\Modules\Bitrix\Infoblock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksProps;

class BitrixInfoblockPropController extends Controller{

    use UserOwnModule;

    public function destroy(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksProps $prop, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsProp($iblock, $prop)){
            return $this->unauthorized($request);
        }

        $module->changeVarInLangFile($prop->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

        $prop->delete();

        BitrixInfoblocks::writeInFile($module);

        return back();
    }
}