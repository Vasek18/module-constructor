@extends('app')

@section('content')

    {{-- todo Проверка на наличие пришедших данных --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                {{-- todo Вынести --}}
                <div class="list-group">
                    <a href="#" class="list-group-item">Детальная</a>
                    <a href="#" class="list-group-item">Добавление инфоблоков</a>
                    <a href="#" class="list-group-item">Добавление компонентов</a>
                    <a href="#" class="list-group-item">Работа с событиями</a>
                    <a href="#" class="list-group-item">Добавление сервисов</a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">Модуль "{{$module->MODULE_NAME}}" ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                <dl class="dl-horizontal">
                                    <dt>Название</dt>
                                    <dd>{{$module->MODULE_NAME}}</dd>
                                    <dt>Описание</dt>
                                    <dd>{{$module->MODULE_DESCRIPTION}}</dd>
                                    <dt>Код</dt>
                                    <dd>{{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}}</dd>
                                    <dt>Версия</dt>
                                    <dd>{{$module->VERSION}}</dd>
                                    <dt>Изменён</dt>
                                    <dd>{{$module->updated_at}}</dd>
                                </dl>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block" href="{{ action('Modules\BitrixController@download_zip', $module->id) }}">Скачать</a>
                                    <a class="btn btn-danger btn-block" href="{{ action('Modules\BitrixController@delete', $module->id) }}">Удалить</a>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="panel-body">
                            Ошибка!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop