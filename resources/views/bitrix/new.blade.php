@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание модуля для Битрикс</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Имя партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_NAME"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Ссылка на ваш сайт</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_URI"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_CODE"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Название модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_NAME"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Описание модуля</label>
                                <div class="col-md-6">
                                    <textarea name="MODULE_DESCRIPTION" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_CODE"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Создать модуль
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop