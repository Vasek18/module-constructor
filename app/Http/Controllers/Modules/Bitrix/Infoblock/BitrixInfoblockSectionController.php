<?php

namespace App\Http\Controllers\Modules\Bitrix\Infoblock;

use App\Models\Modules\Bitrix\BitrixIblocksSections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksProps;

class BitrixInfoblockSectionController extends Controller{

    use UserOwnModule;

    public function create(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }

        $data = [
            'module' => $module,
            'iblock' => $iblock,
        ];

        return view("bitrix.data_storage.iblock_tabs.test_data_section_edit", $data);
    }

    public function store(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }

        $section = BitrixIblocksSections::create([
            'iblock_id' => $iblock->id,
            'name'      => $request['NAME'],
            'code'      => $request['CODE'],
            // todo проверка на уникальность, если она нужна в этом ИБ
            'sort'      => $request['SORT'],
            'active'    => $request['ACTIVE'] == 'Y' ? true : false,
        ]);

        BitrixInfoblocks::writeInFile($module);

        return redirect(action('Modules\Bitrix\Infoblock\BitrixInfoblockSectionController@edit', [
            $module->id,
            $iblock->id,
            $section->id
        ]));
    }

    public function show(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsSection($iblock, $section)){
            return $this->unauthorized($request);
        }

        $data = [
            'module'           => $module,
            'iblock'           => $iblock,
            'properties'       => $iblock->properties()->orderBy('sort', 'asc')->get(),
            'elements'         => $section->elements()->orderBy('sort', 'asc')->get(),
            'sections'         => $section->sections()->orderBy('sort', 'asc')->get(),
            'properties_types' => BitrixIblocksProps::$types,
            'section'          => $section,
        ];

        return view("bitrix.data_storage.add_ib", $data);
    }

    public function edit(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsSection($iblock, $section)){
            return $this->unauthorized($request);
        }

        $data = [
            'module'  => $module,
            'iblock'  => $iblock,
            'section' => $section,
        ];

        return view("bitrix.data_storage.iblock_tabs.test_data_section_edit", $data);
    }

    public function update(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsSection($iblock, $section)){
            return $this->unauthorized($request);
        }

        $section->update([
            'name'   => $request['NAME'],
            'code'   => $request['CODE'],
            // todo проверка на уникальность, если она нужна в этом ИБ
            'sort'   => $request['SORT'],
            'active' => $request['ACTIVE'] == 'Y' ? true : false,
        ]);

        BitrixInfoblocks::writeInFile($module);

        return back();
    }

    public function destroy(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksSections $section, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsSection($iblock, $section)){
            return $this->unauthorized($request);
        }

        $module->changeVarInLangFile($section->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

        $section->delete();

        BitrixInfoblocks::writeInFile($module);

        return back();
    }
}