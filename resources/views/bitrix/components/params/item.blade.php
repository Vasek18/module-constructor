<div class="row option {{$param ? 'draggable' : ''}} deletion_wrapper">
    <input type="hidden"
           name="param_sort[]"
           class="sort-val"
           value="{{$i}}">
    <div class="col-md-3">
        <label class="sr-only"
               for="param_{{$i}}_name">{{ trans('bitrix_components.params_field_name') }}</label>
        <input type="text"
               class="form-control"
               name="param_name[]"
               id="param_{{$i}}_name"
               placeholder="{{ trans('bitrix_components.params_field_name') }}"
               value="{{$param ? $param->name : ''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only"
               for="param_{{$i}}_id">{{ trans('bitrix_components.params_field_code') }}</label>
        <input type="text"
               class="form-control"
               name="param_code[]"
               id="param_{{$i}}_id"
               placeholder="{{ trans('bitrix_components.params_field_code') }}"
               value="{{$param ? $param->code : ''}}"
               @unless ($param) data-translit_from="param_{{$i}}_name" @endif>
    </div>
    <div class="col-md-2">
        <label class="sr-only"
               for="param_{{$i}}_type">{{ trans('bitrix_components.params_field_type') }}</label>
        <select class="form-control"
                name="param_type[]"
                id="param_{{$i}}_type">
            @foreach($params_types as $type)
                <option @if ($param && $param->type == $type->form_type) selected
                        @endif
                        @if ((!$param || !$param->type) && $type->form_type == 'STRING') selected
                        @endif
                        value="{{$type->form_type}}">{{ trans('bitrix_components.params_type_'.$type->form_type) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="sr-only"
               for="param_{{$i}}_group_id">{{ trans('bitrix_components.params_field_group') }}</label>
        <select class="form-control"
                name="param_group_id[]"
                id="param_{{$i}}_group_id">
            @foreach($params_groups as $group)
                <option value="{{$group->id}}"
                        @if ($param && $param->group_id == $group->id) selected @endif
                >{{ trans('bitrix_components.params_group_'.$group->code) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <a href="#"
           class="btn btn-default"
           data-toggle="modal"
           data-target="#component_params_dop_settings_window_{{$i}}">{{ trans('bitrix_components.params_field_dop_params') }}
        </a>
        @include('bitrix.components.params.item_dop_settings_window', ['param' => $param, 'i' => $i])
    </div>
    <div class="col-md-1">
        @if ($param)
            <a href="{{ action('Modules\Bitrix\BitrixComponentsParamsController@destroy', [$module->id, $component->id, $param->id]) }}"
               class="btn btn-danger human_ajax_deletion"
               id="delete_param_{{$component->id}}">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>