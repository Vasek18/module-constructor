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

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('Modules\BitrixController@store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Имя партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_NAME"
                                           value="{{ $user["bitrix_company_name"]?$user["bitrix_company_name"]:$user["company_name"] }}"
                                           required aria-describedby="PARTNER_NAME_help">
                                    <span class="help-block" id="PARTNER_NAME_help">Ваше имя или название вашей компании. Будет отображаться в авторах модуля</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Ссылка на ваш сайт</label>
                                <div class="col-md-6">
                                    <input type="url" class="form-control" name="PARTNER_URI"
                                           value="{{ $user["site"] }}" aria-describedby="PARTNER_URI_help">
                                    <span class="help-block" id="PARTNER_URI_help">Ссылка на ваш сайт или сайт вашей компании. Будет отображаться как ссылка на авторов модуля</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код партнёра</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_CODE"
                                           value="{{ $user["bitrix_partner_code"] }}" required pattern="[a-z]+[a-z0-9]*"
                                           aria-describedby="PARTNER_CODE_help">
                                    <span class="help-block" id="PARTNER_CODE_help">Код партнёра, который указан у вас в личном кабинете партнёра на сайте Битрикса. Учавствует в названии модуля {Код партнёра}.{Код модуля}.<br>Только маленькие латинские буквы</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Название модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_NAME"
                                           value="{{ old('MODULE_NAME') }}" required aria-describedby="MODULE_NAME_help">
                                    <span class="help-block" id="MODULE_NAME_help">Под этим названием модуль будет показываться на сайте Маркетплейса, а также в админке у покупателей, в том числе и в списке модулей с настройками</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Описание модуля</label>
                                <div class="col-md-6">
                                    <textarea name="MODULE_DESCRIPTION" class="form-control"
                                              aria-describedby="MODULE_DESCRIPTION_help">{{ old('MODULE_DESCRIPTION') }}</textarea>
                                    <span class="help-block" id="MODULE_DESCRIPTION_help">Это описание будет показываться только в админке у покупателей в списках установленных модулей. Не обязательно</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Код модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_CODE"
                                           value="{{ old('MODULE_CODE') }}" required pattern="[a-z]+[a-z0-9]*"
                                           aria-describedby="MODULE_CODE_help">
                                    <span class="help-block" id="MODULE_CODE_help">Идентификатор модуля на сайте Битрикса и в админках покупателей. Учавствует в названии модуля {Код партнёра}.{Код модуля}.<br>Только маленькие латинские буквы</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Версия модуля</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_VERSION"
                                           value="0.0.1" required pattern="[0-9\.]+"
                                           aria-describedby="MODULE_VERSION_help">
                                    <span class="help-block" id="MODULE_VERSION_help">Версия модуля.<br>3 цифры разделённые точками не ниже 0.0.1</span>
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
                        <div class="step-description">
                            <h2>Описание шага</h2>
                            <p>На этом шаге создаётся простейший модуль для Битрикса. По сути это всего лишь шаблон
                                модуля, с заполненными основными полями, поскольку в нём отсутствует какой-либо полезный
                                функционал. Уже на данном этапе модуль можно устанавливать и удалять; всю полезную
                                нагрузку можно будет создать в последующих шагах.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop