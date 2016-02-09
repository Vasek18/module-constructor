@extends('app')

@section('content')

    {{-- todo Проверка на наличие пришедших данных --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('bitrix.menu')
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">Основное | Модуль "{{$module->MODULE_NAME}}"
                            ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="post"
                                          action="{{ action('Modules\BitrixController@edit_param', $module->id) }}"
                                          class="readonly">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label for="module_name">Название</label>
                                            <input type="text" id="module_name" class="form-control" name="module_name"
                                                   value="{{$module->MODULE_NAME}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="module_description">Описание</label>
                                        <textarea id="module_description" class="form-control" name="module_description"
                                                  rows="5" readonly>{{$module->MODULE_DESCRIPTION}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="module_description">Код</label>
                                            <p class="form-control-static">{{$module->PARTNER_CODE}}
                                                .{{$module->MODULE_CODE}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="module_description">Версия</label>
                                            <p class="form-control-static">{{$module->VERSION}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="module_description">Изменён</label>
                                            <p class="form-control-static">{{$module->updated_at}}</p>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-1">
                                    {{--<button class="btn btn-primary activate-form" title="Редактировать">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </button>
                                    @push('scripts')
                                    <script src="/js/activate-form.js"></script>
                                    @endpush--}}
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-block"
                                       href="{{ action('Modules\BitrixController@download_zip', $module->id) }}">Скачать</a>
                                    <a class="btn btn-danger btn-block"
                                       href="{{ action('Modules\BitrixController@delete', $module->id) }}">Удалить</a>
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