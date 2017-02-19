<div class="row option {{$option ? 'draggable' : ''}}">
    <input type="hidden"
           name="module_id[]"
           value="{{$module->id}}">
    <input type="hidden"
           class="sort-val"
           name="option_sort[]"
           value="{{$i}}">
    <div class="col-md-4 col-xs-12 xs-margin-bottom">
        <label class="sr-only"
               for="option_{{$i}}_name">{{ trans('bitrix_admin_options.name') }}</label>
        <input type="text"
               class="form-control"
               name="option_name[]"
               id="option_{{$i}}_name"
               placeholder="{{ trans('bitrix_admin_options.name') }}"
               value="{{$option ? $option->name : ''}}">
    </div>
    <div class="col-md-3 col-xs-12 xs-margin-bottom">
        <label class="sr-only"
               for="option_{{$i}}_id">{{ trans('bitrix_admin_options.code') }}</label>
        <input type="text"
               class="form-control"
               name="option_code[]"
               id="option_{{$i}}_id"
               placeholder="{{ trans('bitrix_admin_options.code') }}"
               value="{{$option ? $option->code : ''}}"
               @unless ($option) data-translit_from="option_{{$i}}_name" @endif>
    </div>
    <div class="col-md-2 col-xs-12 xs-margin-bottom">
        <label class="sr-only"
               for="option_{{$i}}_type">{{ trans('bitrix_admin_options.type') }}</label>
        <select class="form-control"
                name="option_type[]"
                id="option_{{$i}}_type">
            @foreach($options_types as $type)
                <option @if ($option && $option['type'] == $type['FORM_TYPE']) selected
                        @endif
                        @if ((!$option || !$option['type']) && $type['FORM_TYPE'] == 'text') selected @endif
                        value="{{$type['FORM_TYPE']}}">{{ trans('bitrix_admin_options.'.$type['FORM_TYPE'].'_type') }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 col-xs-8 xs-margin-bottom">
        <a href="#"
           class="btn btn-default btn-block"
           data-toggle="modal"
           data-target="#admin_options_dop_settings_window_{{$i}}">
            <span class="">
                {{ trans('bitrix_admin_options.additional_settings_button') }}
            </span>
        </a>
    </div>
    <div class="col-md-1 col-xs-4 text-right">
        @if ($option)
            <a href="{{ action('Modules\Bitrix\BitrixOptionsController@destroy', [$module->id, $option->id]) }}"
               class="btn btn-danger btn-sm deletion-with-confirm"
               id="delete_option_{{$option->id}}">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                <span class="sr-only">{{ trans('bitrix_admin_options.delete') }}</span>
            </a>
        @endif
        @if ($option)
            <a href="#"
               class="btn btn-default btn-sm"
               id="get_option_{{$option->id}}_retrieve_code"
               data-toggle="popover"
               title="{{ trans('bitrix_admin_options.bitrix_receive_code') }}"
               data-content="{{$option->bitrix_receive_code}}"
               data-placement="left"
               role="button">
                <span class="glyphicon glyphicon-console"
                      aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>
@include('bitrix.admin_options.dop_settings_window', ['option' => $option, 'i' => $i])