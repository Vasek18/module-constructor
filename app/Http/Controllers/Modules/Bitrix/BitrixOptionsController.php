<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Http\Utilities\Bitrix\AdminOptionsTypes;
use App\Models\Metrics\MetricsEventsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixAdminOptionsVals;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixOptionsController extends Controller{

    use UserOwnModule;

    public function index(Bitrix $module, Request $request){
        $data = [
            'module'        => $module,
            'options'       => $module->options()->orderBy('sort', 'asc')->get(),
            'options_types' => AdminOptionsTypes::all(),
        ];

        return view("bitrix.admin_options.index", $data);
    }

    public function store(Bitrix $module, Request $request){
        // dd($request->all());

        // перебираем все строки полей
        // todo я могу без цикла и перебирания полей обойтись
        foreach ($request->option_code as $i => $option_code){
            $prop = [];
            if (!$option_code){ // отметаем пустые строки
                continue;
            }
            if (!$request['option_name'][$i]){ // если у поля нет имени
                continue;
            }
            if (!$request['option_type'][$i]){ // если у поля нет типа
                continue;
            }
            if ($request['module_id'][$i] != $module->id){ // от хитрых хуесосов
                continue;
            }

            $prop["sort"]      = $request['option_sort'][$i];
            $prop["code"]      = $option_code;
            $prop["name"]      = $request['option_name'][$i];
            $prop["module_id"] = $request['module_id'][$i];
            $prop["type"]      = $request['option_type'][$i];
            $prop["height"]    = $request['option_height'][$i];
            $prop["width"]     = $request['option_width'][$i];
            $prop["spec_vals"] = $request['option_'.$i.'_vals_type'];
            $prop["tab"]       = $request['option_tab'][$i];

            if ($request['option_'.$i.'_spec_args'] && is_array($request['option_'.$i.'_spec_args'])){
                $prop["spec_vals_args"] = '';
                foreach ($request['option_'.$i.'_spec_args'] as $arg){
                    if ($arg){
                        if (!$prop["spec_vals_args"]){
                            $prop["spec_vals_args"] .= $arg;
                        } else{
                            $prop["spec_vals_args"] .= ', '.$arg;
                        }
                    }
                }
            }
            if ($request['option_'.$i.'_spec_args'] && !is_array($request['option_'.$i.'_spec_args'])){
                $prop["spec_vals_args"] = $request['option_'.$i.'_spec_args'];
            }

            if ($prop["type"] == 'checkbox'){
                $prop["spec_vals_args"] = 'Y'; // если спросят, почему нет выбора, мы ответим "зачем?"
            }

            $prop["default_value"] = $request['default_value'][$i];

            //dd($prop);
            // записываем в бд
            $option = BitrixAdminOptions::updateOrCreate(
                [
                    'module_id' => $prop['module_id'],
                    'code'      => $prop['code']
                ],
                $prop
            );

            // логируем действие
            MetricsEventsLog::log('Создана настройка модуля', $option);

            $option->deleteProps(); // чтобы было возможным удалять опшионы

            // сохранение опций
            if ($prop["type"] == 'selectbox' || $prop["type"] == 'multiselectbox'){
                //dd($request["option_'.$i.'_vals_type"]);
                if (count($request['option_'.$i.'_vals_key']) && $request['option_'.$i.'_vals_type'] == "array"){
                    //dd($prop);
                    //dd($request['option_'.$i.'_vals_key']);
                    foreach ($request['option_'.$i.'_vals_key'] as $io => $option_val_key){
                        if (!$option_val_key || !$request['option_'.$i.'_vals_value'][$io]){
                            continue;
                        }

                        $is_default = false;
                        if (isset($request['option_'.$i.'_vals_default']) && $request['option_'.$i.'_vals_default'] == $io){
                            $is_default = true;
                            $option->update(['default_value' => $option_val_key]);
                        }

                        $val = BitrixAdminOptionsVals::updateOrCreate(
                            [
                                'option_id' => $option->id,
                                'key'       => $option_val_key
                            ],
                            [
                                'option_id'  => $option->id,
                                'key'        => $option_val_key,
                                'value'      => $request['option_'.$i.'_vals_value'][$io],
                                'is_default' => $is_default,
                            ]
                        );
                    }
                }
            }
        }

        // записываем в папку модуля
        BitrixAdminOptions::saveOptionFile($module);

        return back();
    }

    // удаление поля для страницы настроек
    public function destroy(Bitrix $module, BitrixAdminOptions $option, Request $request){
        if (!$this->moduleOwnsOption($module, $option)){
            return $this->unauthorized($request);
        }
        if (!$option->id || !$module->id){
            return false;
        }
        // удаляем запись из БД
        BitrixAdminOptions::destroy($option->id);

        // производим замены в папке модуля
        BitrixAdminOptions::saveOptionFile($module);

        return back();
    }
}
