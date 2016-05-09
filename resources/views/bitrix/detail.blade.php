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
                    <p class="form-control-static">{{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}}</p>
                </div>
                <div class="form-group">
                    <label for="name">Название</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="name"
                           data-pattern="[a-zA-Zа-яА-Я0-9]*">{{$module->MODULE_NAME}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="description"
                           data-formtype="textarea">{{$module->MODULE_DESCRIPTION}}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="version">Версия</label>
                    <p class="form-control-static">
                        <a href="#" class="you-can-change ajax" data-name="version">{{$module->VERSION}}</a>
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
            <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_download" href="#">Скачать</a>
            <a class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal_delete" href="#">Удалить</a>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_download">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Скачивание модуля</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ action('Modules\Bitrix\BitrixController@download_zip', $module->id) }}"
                          method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="version">Версия</label>
                            <input class="form-control" type="text" name="version" id="version" required
                                   value="{{upgradeVersionNumber($module->VERSION)}}">
                        </div>
                        <button type="submit" class="btn btn-primary" name="module_download">Скачать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Удаление модуля</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">Вы уверены?</div>
                    <form method="post"
                          action="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}"
                          class="readonly">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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