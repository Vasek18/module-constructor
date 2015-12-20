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

                        <form class="form-horizontal" role="form" method="POST" action="{{ action('Modules\BitrixController@create') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Имя партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_NAME"
                                           value="" required aria-describedby="PARTNER_NAME_help">
                                    <span class="help-block" id="PARTNER_NAME_help">Ваше имя или название вашей компании. Будет отображаться в авторах модуля</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Ссылка на ваш сайт</label>
                                <div class="col-md-6">
                                    <input type="url" class="form-control" name="PARTNER_URI"
                                           value="" aria-describedby="PARTNER_URI_help">
                                    <span class="help-block" id="PARTNER_URI_help">Ссылка на ваш сайт или сайт вашей компании. Будет отображаться как ссылка на авторов модуля</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_CODE"
                                           value="" required pattern="[a-z]+" aria-describedby="PARTNER_CODE_help">
                                    <span class="help-block" id="PARTNER_CODE_help">Код партнёра, который указан у вас в личном кабинете партнёра на сайте Битрикса. Учавствует в названии модуля {Код партнёра}.{Код модуля}.<br>Только маленькие латинские буквы</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Название модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_NAME"
                                           value="" required aria-describedby="MODULE_NAME_help">
                                    <span class="help-block" id="MODULE_NAME_help">Под этим названием модуль будет показываться на сайте Маркетплейса, а также в админке у покупателей, в том числе и в списке модулей с настройками</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Описание модуля</label>
                                <div class="col-md-6">
                                    <textarea name="MODULE_DESCRIPTION" class="form-control" aria-describedby="MODULE_DESCRIPTION_help"></textarea>
                                    <span class="help-block" id="MODULE_DESCRIPTION_help">Это описание будет показываться только в админке у пакупателей в списках установленных модулей. Не обязательно</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_CODE"
                                           value="" required pattern="[a-z]+" aria-describedby="MODULE_CODE_help">
                                    <span class="help-block" id="MODULE_CODE_help">Идентификатор модуля на сатйе Битрикса и в админках покупателей. Учавствует в названии модуля {Код партнёра}.{Код модуля}.<br>Только маленькие латинские буквы</span>
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