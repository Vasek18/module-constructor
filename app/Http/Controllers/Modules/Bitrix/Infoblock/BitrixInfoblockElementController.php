<?php

namespace App\Http\Controllers\Modules\Bitrix\Infoblock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksElements;

class BitrixInfoblockElementController extends Controller{

    use UserOwnModule;

    public static $arrayGlue = '_###_';

    public function create(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }

        $data = [
            'module'            => $module,
            'iblock'            => $iblock,
            'sections'          => $iblock->sections()->orderBy('sort', 'asc')->get(),
            'properties'        => $iblock->properties()->orderBy('sort', 'asc')->get(),
            'elements_for_bind' => $iblock->getElementsOfIblocksWithLowerSort(),
            'sections_for_bind' => $iblock->getSectionsOfIblocksWithLowerSort(),
        ];

        return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
    }

    public function store(Bitrix $module, BitrixInfoblocks $iblock, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }

        $element = BitrixIblocksElements::create([
            'iblock_id'         => $iblock->id,
            'name'              => $request['NAME'],
            'code'              => $request['CODE'],
            // todo проверка на уникальность, если она нужна в этом ИБ
            'sort'              => $request['SORT'],
            'active'            => $request['ACTIVE'] == 'Y' ? true : false,
            'parent_section_id' => $request['SECTION_ID'],
        ]);

        if ($request->props){
            $attachArr = [];
            foreach ($request->props as $id => $val){
                if (!$val){
                    continue;
                }
                $prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('id', $id)->first();
                if (!$prop){
                    continue;
                }
                if (is_array($val)){
                    foreach ($val as $cVal => $valVal){
                        if (!$valVal){
                            unset($val[$cVal]); // удаляем пустые
                        }
                    }
                    $val = implode(static::$arrayGlue, $val);
                }

                $attachArr[$prop->id] = ['value' => $val];
            }
            $element->props()->sync($attachArr);
        }

        BitrixInfoblocks::writeInFile($module);

        return redirect(action('Modules\Bitrix\Infoblock\BitrixInfoblockElementController@edit', [
            $module->id,
            $iblock->id,
            $element->id
        ]));
    }

    public function edit(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsElement($iblock, $element)){
            return $this->unauthorized($request);
        }

        $props_vals = [];
        foreach ($element->props as $prop){
            $val = $prop->pivot->value;
            if (strpos($val, static::$arrayGlue) !== false){
                $val = explode(static::$arrayGlue, $val);
            }
            if ($prop->multiple && !is_array($val)){ // у множественного своства одно значение
                $val = [$val];
            }
            $props_vals[$prop->id] = $val;
        }

        $data = [
            'module'            => $module,
            'iblock'            => $iblock,
            'element'           => $element,
            'props_vals'        => $props_vals,
            'properties'        => $iblock->properties()->orderBy('sort', 'asc')->get(),
            'sections'          => $iblock->sections()->orderBy('sort', 'asc')->get(),
            'elements_for_bind' => $iblock->getElementsOfIblocksWithLowerSort(),
            'sections_for_bind' => $iblock->getSectionsOfIblocksWithLowerSort(),
        ];

        //dd($data);

        return view("bitrix.data_storage.iblock_tabs.test_data_element_edit", $data);
    }

    public function update(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsElement($iblock, $element)){
            return $this->unauthorized($request);
        }

        // dd($request->all());

        $element->update([
            'name'              => $request['NAME'],
            'code'              => $request['CODE'],
            // todo проверка на уникальность, если она нужна в этом ИБ
            'sort'              => $request['SORT'],
            'active'            => $request['ACTIVE'] == 'Y' ? true : false,
            'parent_section_id' => $request['SECTION_ID'],
        ]);

        $attachArr = [];
        if ($request->props){
            foreach ($request->props as $id => $val){
                if (!$val){
                    continue;
                }
                $prop = BitrixIblocksProps::where('iblock_id', $iblock->id)->where('id', $id)->first();
                if (!$prop){
                    continue;
                }
                if (is_array($val)){
                    foreach ($val as $cVal => $valVal){
                        if (!$valVal){
                            unset($val[$cVal]); // удаляем пустые
                        }
                    }
                    $val = implode(static::$arrayGlue, $val);
                }

                $attachArr[$prop->id] = ['value' => $val];
            }
            $element->props()->sync($attachArr);
        }

        BitrixInfoblocks::writeInFile($module);

        return back();
    }

    public function destroy(Bitrix $module, BitrixInfoblocks $iblock, BitrixIblocksElements $element, Request $request){
        if (!$this->moduleOwnsIblock($module, $iblock)){
            return $this->unauthorized($request);
        }
        if (!$this->iblockOwnsElement($iblock, $element)){
            return $this->unauthorized($request);
        }

        $module->changeVarInLangFile($element->lang_key."_NAME", "", '/lang/'.$module->default_lang.'/install/index.php');

        $element->delete();

        BitrixInfoblocks::writeInFile($module);

        return back();
    }
}