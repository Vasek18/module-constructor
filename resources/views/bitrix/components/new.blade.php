@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание модуля для Битрикс - шаг 1</div>
                    <div class="panel-body">
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

                        <form class="form-horizontal" role="form" method="POST" action="{{ action('Modules\BitrixController@component_create', $module->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Название компонента</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="COMPONENT_NAME"
                                           value="" required aria-describedby="COMPONENT_NAME_help">
                                    <span class="help-block" id="COMPONENT_NAME_help"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код компонента</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="COMPONENT_CODE"
                                           value="" required aria-describedby="COMPONENT_CODE_help">
                                    <span class="help-block" id="COMPONENT_CODE_help"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Описание компонента</label>
                                <div class="col-md-6">
                                    <textarea name="COMPONENT_DESCRIPTION" class="form-control" aria-describedby="COMPONENT_DESCRIPTION_help"></textarea>
                                    <span class="help-block" id="COMPONENT_DESCRIPTION_help"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Создать компонент
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="step-description">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop