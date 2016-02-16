@extends('bitrix.internal_template')

@section('h1')
    Страница настроек
@stop

@section('page')
    @push('scripts')
    <script src="/js/bitrix_module_admin_options.js"></script>
    @endpush
    <form role="form" method="POST" action="{{ action('Modules\BitrixOptionsController@store', $module->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row option-headers">
            <div class="col-md-2">
                <label>Код свойства</label>
            </div>
            <div class="col-md-3">
                <label>Название свойства</label>
            </div>
            <div class="col-md-3">
                <label>Тип свойства</label>
            </div>
            <div class="col-md-2">
                <label>Доп. поля</label>
            </div>
            <div class="col-md-2">
                <label>Удалить</label>
            </div>
        </div>
        @foreach($options as $i => $option)
            <div class="row option">
                <input type="hidden" name="option_number" value="{{$i}}">
                <input type="hidden" name="option_{{$i}}_width" value="{{$option->width}}">
                <input type="hidden" name="option_{{$i}}_height" value="{{$option->height}}">
                <input type="hidden" name="option_{{$i}}_vals">
                <div class="col-md-2">
                    <label class="sr-only" for="option_{{$i}}_id">ID</label>
                    <input type="text" class="form-control" name="option_code[]" id="option_{{$i}}_id"
                           placeholder="ID" value="{{$option->code}}">
                </div>
                <div class="col-md-3">
                    <label class="sr-only" for="option_{{$i}}_name">Название</label>
                    <input type="text" class="form-control" name="option_{{$i}}_name"
                           id="option_{{$i}}_name"
                           placeholder="Название" value="{{$option->name}}">
                </div>
                <div class="col-md-3">
                    <label class="sr-only" for="option_{{$i}}_type">Тип</label>
                    <select class="form-control" name="option_{{$i}}_type" id="option_{{$i}}_type">
                        @foreach(DB::table('bitrix_modules_options_types')->get() as $type)
                            <option @if ($option->type_id == $type->id) selected
                                    @endif value="{{$type->id}}">{{$type->NAME_RU}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-default" data-toggle="modal"
                       data-target="#admin_options_dop_settings_window">Редактировать</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ action('Modules\BitrixOptionsController@destroy', [$module->id, $option->id]) }}"
                       class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        Удалить
                    </a>
                </div>
            </div>
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($options); $j < count($options)+5; $j++)
            <div class="row option">
                <div class="col-md-2">
                    <label class="sr-only" for="option_{{$j}}_code">Код</label>
                    <input type="text" class="form-control" name="option_code[]" id="option_{{$j}}_code"
                           placeholder="Код">
                </div>
                <div class="col-md-3">
                    <label class="sr-only" for="option_{{$j}}_name">Название</label>
                    <input type="text" class="form-control" name="option_{{$j}}_name"
                           id="option_{{$j}}_name"
                           placeholder="Название">
                </div>
                <div class="col-md-3">
                    <label class="sr-only" for="option_{{$j}}_type">Тип</label>
                    <select class="form-control" name="option_{{$j}}_type" id="option_{{$j}}_type">
                        @foreach(DB::table('bitrix_modules_options_types')->get() as $type)
                            <option value="{{$type->id}}">{{$type->NAME_RU}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-2">

                </div>
            </div>
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>
    @include('bitrix.admin_options_dop_settings_window')
@stop