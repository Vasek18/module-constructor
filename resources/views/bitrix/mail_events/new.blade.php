@extends('bitrix.internal_template')

@section('h1')
    Создание почтового события
@stop

@push('scripts')
<script src="/js/bitrix_mail_event_create_form.js"></script>
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

    <form class="form-horizontal" role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixMailEventsController@store', $module->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-4 control-label">Название почтового события</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="MAIL_EVENT_NAME"
                       value="" required aria-describedby="MAIL_EVENT_NAME_help" id="MAIL_EVENT_NAME">
                <span class="help-block" id="MAIL_EVENT_NAME_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Код (тип) почтового события</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="MAIL_EVENT_CODE"
                       value="" required aria-describedby="MAIL_EVENT_CODE_help" id="MAIL_EVENT_CODE"
                       data-translit_from="MAIL_EVENT_NAME" data-transform="uppercase">
                <span class="help-block" id="MAIL_EVENT_CODE_help"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Переменные</label>
            <div class="col-md-2">
                <textarea name="MAIL_EVENT_VARS" class="form-control" id="MAIL_EVENT_VARS" rows="10"
                          aria-describedby="MAIL_EVENT_VARS_help"></textarea>
                <span class="help-block" id="MAIL_EVENT_VARS_help"></span>
            </div>
            <div class="col-md-4 vals-list">
                @for($i=0; $i<5; $i++)
                    <div class="form-group">
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Название" name="MAIL_EVENT_VARS_NAMES[]" id="MAIL_EVENT_VARS_NAME_{{$i}}">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Код" name="MAIL_EVENT_VARS_CODES[]" id="MAIL_EVENT_VARS_CODE_{{$i}}"
                                   data-translit_from="MAIL_EVENT_VARS_NAME_{{$i}}" data-transform="uppercase">
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Вес сортировки</label>
            <div class="col-md-6">
                <input type="text" name="MAIL_EVENT_SORT" class="form-control" aria-describedby="MAIL_EVENT_SORT_help"
                       value="500">
                <span class="help-block" id="MAIL_EVENT_SORT_help"></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary" name="create">
                    Создать
                </button>
            </div>
        </div>
    </form>
    <div class="step-description">
    </div>
@stop