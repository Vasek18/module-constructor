@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix.detail_h1') }}
@stop

@section('page')
    {{--также нужна краткая сводка со всех остальных страниц--}}
    <div class="row">
        <div class="col-md-10">
            <form method="post"
                  action="{{ action('Modules\Bitrix\BitrixController@update', $module->id) }}"
                  class="readonly">
                <input type="hidden"
                       name="_token"
                       value="{{ csrf_token() }}">
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label>{{ trans('bitrix.field_code') }}</label>
                    <p class="form-control-static">{{$module->PARTNER_CODE}}.{{$module->code}}</p>
                </div>
                <div class="form-group">
                    <label for="name">{{ trans('bitrix.field_name') }}</label>
                    <p class="form-control-static">
                        <a href="#"
                           class="you-can-change ajax"
                           data-name="name"
                           data-pattern="[a-zA-Zа-яА-Я0-9]*">{{$module->getVarFromLangFile('MODULE_NAME')}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('bitrix.field_description') }}</label>
                    <p class="form-control-static">
                        <a href="#"
                           class="you-can-change ajax"
                           data-name="description"
                           data-formtype="textarea">{{$module->getVarFromLangFile('MODULE_DESC')}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="version">{{ trans('bitrix.field_version') }}</label>
                    <p class="form-control-static">
                        <a href="#"
                           class="you-can-change ajax"
                           data-name="version">{{$module->version}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label>{{ trans('bitrix.updated_at') }}</label>
                    <p class="form-control-static">{{$module->updated_at}}</p>
                </div>
                <button type="submit"
                        class="hidden">{{ trans('app.save') }}
                </button>
            </form>
        </div>
        <div class="col-md-2">
            @if ($user->canDownloadModule())
                @include('bitrix.download_modal', [ 'module' => $module])
                <a class="btn btn-sm btn-success btn-block"
                   data-toggle="modal"
                   data-target="#modal_download_{{$module->id}}"
                   href="#">
                    <span class="glyphicon glyphicon-download"
                          aria-hidden="true"></span>
                    {{ trans('app.download') }}
                </a>
            @endif
            <a class="btn btn-sm btn-danger btn-block"
               data-toggle="modal"
               data-target="#modal_delete_{{$module->id}}"
               id="delete_{{$module->id}}"
               href="#">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                {{ trans('app.delete') }}
            </a>
        </div>
    </div>
    @include('bitrix.delete_modal', [ 'module' => $module])
    <h2>{{ trans('bitrix.consist_of') }}</h2>
    <dl class="dl-horizontal">
        <dt>{{ trans('bitrix.components_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_components', $module->id) }}">{{$module->components()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.events_handlers_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_events_handlers', $module->id) }}">{{$module->handlers()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.infoblocks_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_data_storage', $module->id) }}">{{$module->infoblocks()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.admin_options_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_admin_options', $module->id) }}">{{$module->options()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.mail_events_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_mail_events', $module->id) }}">{{$module->mailEvents()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.arbitrary_files_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_arbitrary_files', $module->id) }}">{{$module->arbitraryFiles()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.admin_menu_pages_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_admin_menu', $module->id) }}">{{$module->adminMenuPages()->count()}}</a>
        </dd>
    </dl>
@stop