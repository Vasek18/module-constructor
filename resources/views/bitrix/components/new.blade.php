@extends('bitrix.internal_template')

@section('h1')
    Создание компонента
@stop

@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Ошибка!</strong> При заполнение формы возникли ошибки<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal" role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixComponentsController@store', $module->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-4 control-label">Название компонента</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="COMPONENT_NAME"
                       value="" required aria-describedby="COMPONENT_NAME_help" id="component_name">
                <span class="help-block" id="COMPONENT_NAME_help">Название компонента, которое будет отображаться в визуальном редакторе, да и во всяких списках внутри конструктора.</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Код компонента</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="COMPONENT_CODE"
                       value="" required aria-describedby="COMPONENT_CODE_help" id="component_code" data-translit_from="component_name">
                <span class="help-block" id="COMPONENT_CODE_help">Этот код используется в подключении компонента в php-коде.</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Описание компонента</label>
            <div class="col-md-6">
                <textarea name="COMPONENT_DESCRIPTION" class="form-control"
                          aria-describedby="COMPONENT_DESCRIPTION_help"></textarea>
                <span class="help-block" id="COMPONENT_DESCRIPTION_help">Показывается при редактировании параметров компонента при наведении на кнопочку с 'i'. Но в любом случае не лишним будет.</span>
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
            <label class="col-md-4 control-label">Вес сортировки компонента</label>
            <div class="col-md-6">
                <input type="text" name="COMPONENT_SORT" class="form-control" aria-describedby="COMPONENT_SORT_help">
                <span class="help-block" id="COMPONENT_SORT_help">Это нужно для сортировки в списке компонентов внутри группы при редактировании страницы.</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary" name="create_component">
                    Создать компонент
                </button>
            </div>
        </div>
    </form>
    <div class="step-description">
    </div>
@stop