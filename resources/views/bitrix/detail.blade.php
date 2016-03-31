@extends('bitrix.internal_template')

@section('h1')
    Основное
@stop

@section('page')
    {{--также нужна краткая сводка со всех остальных страниц--}}
    <div class="row">
        <div class="col-md-10">
            <form method="post"
                  action="{{ action('Modules\Bitrix\BitrixController@edit_param', $module->id) }}"
                  class="readonly">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="clearfix">
                    <a href="#" class="btn btn-primary pull-right activate-form">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                </div>
                <div class="form-group">
                    <label for="module_name">Название</label>
                    <input type="text" id="module_name" class="form-control" name="module_name"
                           value="{{$module->MODULE_NAME}}" readonly>
                </div>
                <div class="form-group">
                    <label for="module_description">Описание</label>
                    <textarea id="module_description" class="form-control"
                              name="module_description"
                              rows="5" readonly>{{$module->MODULE_DESCRIPTION}}</textarea>
                </div>
                <div class="form-group">
                    <label for="module_description">Код</label>
                    <p class="form-control-static">{{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}}</p>
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
                    <a class="btn btn-danger"
                       href="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}">Удалить</a>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script src="/js/activate-form.js"></script>
@endpush