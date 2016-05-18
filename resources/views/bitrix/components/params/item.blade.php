<div class="row option {{$param ? 'draggable' : ''}}">
    <input type="hidden" name="param_sort[]" class="sort-val" value="{{$i}}">
    <div class="col-md-3">
        <label class="sr-only" for="param_{{$i}}_name">Название</label>
        <input type="text" class="form-control" name="param_name[]"
               id="param_{{$i}}_name"
               placeholder="Название" value="{{$param ? $param->name : ''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="param_{{$i}}_id">Код</label>
        <input type="text" class="form-control" name="param_code[]" id="param_{{$i}}_id"
               placeholder="Код" value="{{$param ? $param->code : ''}}"
               @unless ($param) data-translit_from="param_{{$i}}_name" @endif>
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="param_{{$i}}_type">Тип</label>
        <select class="form-control" name="param_type[]" id="param_{{$i}}_type">
            @foreach($params_types as $type)
                <option @if ($param && $param->type_id == $type->id) selected
                        @endif value="{{$type->id}}">{{$type->name_ru}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="param_{{$i}}_group_id">Группа</label>
        <select class="form-control" name="param_group_id[]" id="param_{{$i}}_group_id">
            @foreach($params_groups as $group)
                <option @if ($param && $param->group_id == $group->id) selected
                        @endif value="{{$group->id}}">{{$group->name?$group->name:$group->code}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <a href="#" class="btn btn-default" data-toggle="modal"
           data-target="#component_params_dop_settings_window_{{$i}}">Доп. параметры
        </a>
        @include('bitrix.components.params.item_dop_settings_window', ['param' => $param, 'i' => $i])
    </div>
    <div class="col-md-1">
        @if ($param)
            <a href="{{ action('Modules\Bitrix\BitrixComponentsParamsController@destroy', [$module->id, $component->id, $param->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>