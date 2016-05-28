@extends('bitrix.internal_template')

@section('h1')
    {{$template ? 'Шаблон "'.$template->name.'"' : 'Создание почтового шаблона'}} | Почтовое событие {{ $mail_event->name }} ({{ $mail_event->code }})
@stop

@push('scripts')
<script src="/js/bitrix_mail_template_form.js"></script>
@endpush

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

    <form
            class="form-horizontal"
            role="form"
            method="POST"
            @if ($template)
            action="{{ action('Modules\Bitrix\BitrixMailEventsController@update_template', [$module->id, $mail_event->id, $template->id]) }}"
            @else
            action="{{ action('Modules\Bitrix\BitrixMailEventsController@store_template', [$module->id, $mail_event->id]) }}"
            @endif
    >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-4 control-label">Название</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name"
                       value="{{$template ? $template->name : ''}}" required aria-describedby="name_help">
                <span class="help-block" id="name_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">От кого</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="from" name="from"
                       value="{{$template ? $template->from : '#DEFAULT_EMAIL_FROM#'}}" required
                       aria-describedby="from_help">
                <span class="help-block" id="from_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Кому</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="to" name="to"
                       value="{{$template ? $template->to : '#EMAIL_TO#'}}" required aria-describedby="to_help">
                <span class="help-block" id="to_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Копия</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="copy" name="copy"
                       value="{{$template ? $template->copy : ''}}" aria-describedby="copy_help">
                <span class="help-block" id="copy_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Скрытая копия</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="hidden_copy" name="hidden_copy"
                       value="{{$template ? $template->hidden_copy : ''}}" aria-describedby="hidden_copy_help">
                <span class="help-block" id="hidden_copy_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Обратный адрес</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="reply_to" name="reply_to"
                       value="{{$template ? $template->reply_to : ''}}" aria-describedby="reply_to_help">
                <span class="help-block" id="reply_to_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Ответ на сообщение</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="in_reply_to" name="in_reply_to"
                       value="{{$template ? $template->in_reply_to : ''}}" aria-describedby="in_reply_to_help">
                <span class="help-block" id="in_reply_to_help"></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <textarea name="body" id="" class="form-control" rows="20">{{$template ? $template->body : ''}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="available-vals">
                    <h3>Переменные</h3>
                    @foreach($mail_event->vars as $var)
                        <p>
                            <a href="#" data-var="{{$var->code}}">{{$var->code}} ({{$var->name}})</a>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-primary btn-block" name="save">
                    Сохранить
                </button>
            </div>
        </div>
    </form>
@stop