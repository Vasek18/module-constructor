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
        <div class="col-md-2">
            <a class="btn btn-primary btn-block"
               href="{{ action('Modules\Bitrix\BitrixController@download_zip', $module->id) }}">Скачать</a>
            <a class="btn btn-danger btn-block"
               href="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}">Удалить</a>
        </div>
    </div>
@stop