@extends('bitrix.components.templates.internal_template')

@section('h1')
    {{$template ? trans('bitrix_components.template').'"'.$template->code.'"' : trans('bitrix_components.templates_create_title')}} | {{ $component->name }} ({{ $component->code }})
@stop

@section('templates_page')
    <h2>{{ trans('bitrix_components.template_detail_title') }}</h2>
    <div class="col-md-9">
        <form method="post"
              action="{{$template ? action('Modules\Bitrix\BitrixComponentsTemplatesController@update', [$module->id, $component->id, $template->id]) : action('Modules\Bitrix\BitrixComponentsTemplatesController@store', [$module->id, $component->id])}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="code">{{ trans('bitrix_components.templates_field_code') }}</label>
                @if ($template)
                    <p class="form-control-static">{{$template ? $template->code : ""}}</p>
                @else
                    <input type="text"
                           class="form-control"
                           name="code"
                           id="code"
                           required
                           value="{{$template ? $template->code : ""}}">
                @endif
            </div>
            <div class="form-group">
                <label for="name">{{ trans('bitrix_components.templates_field_name') }}</label>
                <input type="text"
                       class="form-control"
                       name="name"
                       id="name"
                       value="{{$template ? $template->name : ""}}">
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_template_php_code') }}</label>
                <textarea class="form-control"
                          rows="20"
                          name="template_php">{{$template ? $template->template_php : ""}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_style_css_code') }}</label>
                <textarea class="form-control"
                          rows="20"
                          name="style_css">{{$template ? $template->style_css : ""}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_script_js_code') }}</label>
                <textarea class="form-control"
                          rows="20"
                          name="script_js">{{$template ? $template->script_js : ""}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_result_modifier_php_code') }}</label>
                <textarea class="form-control"
                          rows="20"
                          name="result_modifier_php">{{$template ? $template->result_modifier_php : ""}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_component_epilog_php_code') }}</label>
                <textarea class="form-control"
                          rows="20"
                          name="component_epilog_php">{{$template ? $template->component_epilog_php : ""}}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"
                        name="save">{{ trans('app.save') }}</button>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-1">
        @if ($template)
            <p>
                <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@destroy', [$module->id, $component->id, $template->id]) }}"
                   class="btn btn-sm btn-danger"
                   id="delete">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                    {{ trans('app.delete') }}
                </a>
            </p>
        @endif
    </div>
@stop
