@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.new_h1') }}
@stop

@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('validation.error') }}</strong> {{ trans('validation.there_occur_errors') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal"
          role="form"
          method="POST"
          action="{{ action('Modules\Bitrix\BitrixComponentsController@store', $module->id) }}">
        <input type="hidden"
               name="_token"
               value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-4 control-label">{{ trans('bitrix_components.field_component_name') }}</label>
            <div class="col-md-6">
                <input type="text"
                       class="form-control"
                       name="name"
                       value=""
                       required
                       aria-describedby="name_help"
                       id="component_name">
                <span class="help-block"
                      id="name_help">{{ trans('bitrix_components.field_component_name_help') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">{{ trans('bitrix_components.field_component_code') }}</label>
            <div class="col-md-6">
                <input type="text"
                       class="form-control"
                       name="code"
                       value=""
                       required
                       aria-describedby="code_help"
                       id="component_code"
                       data-translit_from="component_name" {{--todo убирать знаки--}}
                >
                <span class="help-block"
                      id="code_help">{{ trans('bitrix_components.field_component_code_help') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">{{ trans('bitrix_components.field_component_desc') }}</label>
            <div class="col-md-6">
                <textarea name="desc"
                          class="form-control"
                          aria-describedby="desc_help"></textarea>
                <span class="help-block"
                      id="description_help">{{ trans('bitrix_components.field_component_desc_help') }}</span>
            </div>
        </div>
        {{--todo--}}
        {{--<div class="form-group">
            <label class="col-md-4 control-label">Иконка компонента</label>
            <div class="col-md-6">
                <input type="file" name="COMPONENT_ICON" class="form-control" aria-describedby="COMPONENT_ICON_help">
                <span class="help-block" id="COMPONENT_ICON_help"></span>
            </div>
        </div>--}}
        <div class="form-group">
            <label class="col-md-4 control-label">{{ trans('bitrix_components.field_component_sort') }}</label>
            <div class="col-md-6">
                <input type="text"
                       name="sort"
                       class="form-control"
                       aria-describedby="sort_help"
                       value="500">
                <span class="help-block"
                      id="sort_help">{{ trans('bitrix_components.field_component_sort_help') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">{{ trans('bitrix_components.field_component_namespace') }}</label>
            <div class="col-md-6">
                <input type="text"
                       name="namespace"
                       class="form-control"
                       aria-describedby="namespace_help"
                       value="{{ $module->module_full_id }}">
                <span class="help-block"
                      id="namespace_help">{{ trans('bitrix_components.field_component_namespace_help') }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit"
                        class="btn btn-primary"
                        name="create_component">
                    {{ trans('bitrix_components.button_create_component') }}
                </button>
            </div>
        </div>
    </form>
    <div class="step-description"></div>
@stop