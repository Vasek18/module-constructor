@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.template') }} "{{ $template->code }}" | {{ $component->name }} ({{ $component->code }})
@stop

@section('page')
    @include('bitrix.components.progress_way_menu')
    <h2>{{ trans('bitrix_components.template_detail_title') }}</h2>
    <div class="col-md-9">
        <form method="post"
              action="">
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_template_php_code') }}</label>
                <textarea class="form-control"
                          rows="20">{{$template->template_php}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_style_css_code') }}</label>
                <textarea class="form-control"
                          rows="20">{{$template->style_css}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_script_js_code') }}</label>
                <textarea class="form-control"
                          rows="20">{{$template->script_js}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_result_modifier_php_code') }}</label>
                <textarea class="form-control"
                          rows="20">{{$template->result_modifier_php}}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.template_field_component_epilog_php_code') }}</label>
                <textarea class="form-control"
                          rows="20">{{$template->component_epilog_php}}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="save">{{ trans('app.save') }}</button>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-1">
        <p>
            <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@destroy', [$module->id, $component->id, $template->id]) }}"
               class="btn btn-sm btn-danger"
               id="delete">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                {{ trans('app.delete') }}
            </a>
        </p>
    </div>
@stop
