@extends('bitrix.internal_template')

@section('h1')
    Основное
@stop

@section('page')
    {{--также нужна краткая сводка со всех остальных страниц--}}
    <div class="row">
        <div class="col-md-10">
            <form method="post"
                  action="{{ action('Modules\Bitrix\BitrixController@update', $module->id) }}"
                  class="readonly">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label>Код</label>
                    <p class="form-control-static">{{$module->PARTNER_CODE}}.{{$module->code}}</p>
                </div>
                <div class="form-group">
                    <label for="name">Название</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="name"
                           data-pattern="[a-zA-Zа-яА-Я0-9]*">{{$module->name}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="description"
                           data-formtype="textarea">{{$module->description}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="version">Версия</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="version">{{$module->version}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label>Изменён</label>
                    <p class="form-control-static">{{$module->updated_at}}</p>
                </div>
                <button type="submit" class="hidden">Сохранить</button>
            </form>
        </div>
        <div class="col-md-2">
            @if ($module->can_download)
                <a class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#modal_download_{{$module->id}}" href="#">
                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
                    Скачать
                </a>
            @endif
            <a class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#modal_delete_{{$module->id}}"
               href="#">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                Удалить
            </a>
        </div>
    </div>
    @include('bitrix.download_modal', [ 'module' => $module])
    @include('bitrix.delete_modal', [ 'module' => $module])
    <h2>Модуль содержит</h2>
    <dl>
        <dt>Компонентов:</dt>
        <dd>
            <a href="{{ route('bitrix_module_components', $module->id) }}">{{$module->components()->count()}}</a>
        </dd>
        <dt>Обработчиков событий:</dt>
        <dd>
            <a href="{{ route('bitrix_module_events_handlers', $module->id) }}">{{$module->handlers()->count()}}</a>
        </dd>
        <dt>Инфоблоков:</dt>
        <dd>
            <a href="{{ route('bitrix_module_data_storage', $module->id) }}">{{$module->infoblocks()->count()}}</a>
        </dd>
        <dt>Настроек:</dt>
        <dd>
            <a href="{{ route('bitrix_module_admin_options', $module->id) }}">{{$module->options()->count()}}</a>
        </dd>
    </dl>
@stop