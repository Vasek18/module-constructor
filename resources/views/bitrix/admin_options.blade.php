@extends('app')

@section('content')

    {{-- todo Проверка на наличие пришедших данных --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('bitrix.menu')
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">Страница настроек | Модуль "{{$module->MODULE_NAME}}"
                            ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="{{ action('Modules\BitrixController@admin_options_save', $module->id) }}" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row option-headers">
                                    <div class="col-md-2">
                                        <label>Код свойства</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Название свойства</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Тип свойства</label>
                                    </div>
                                </div>
                                @foreach($options as $i => $option)
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_id">ID</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_id" id="option_{{$i}}_id"
                                                   placeholder="ID">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_name">Название</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_name"
                                                   id="option_{{$i}}_name"
                                                   placeholder="Название">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_type">Тип</label>
                                            <select class="form-control" name="option_{{$i}}_type" id="option_{{$i}}_type">
                                                <option value="">Выберите тип</option>
                                                @foreach($optionsTypes as $type)
                                                    <option value="">{{$type->NAME_RU}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_width">Ширина</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_width"
                                                   id="option_{{$i}}_width"
                                                   placeholder="Ширина">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_height">Высота</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_height"
                                                   id="option_{{$i}}_height"
                                                   placeholder="Высота">
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Дополнительно показываем ещё несколько пустых строк --}}
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="row option">
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_code">Код</label>
                                            <input type="text" class="form-control" name="option_code[]" id="option_{{$i}}_code"
                                                   placeholder="Код">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="sr-only" for="option_{{$i}}_name">Название</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_name"
                                                   id="option_{{$i}}_name"
                                                   placeholder="Название">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_type">Тип</label>
                                            <select class="form-control" name="option_{{$i}}_type" id="option_{{$i}}_type">
                                                <option value="">Выберите тип</option>
                                                @foreach($optionsTypes as $type)
                                                    <option value="{{$type->id}}">{{$type->NAME_RU}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_width">Ширина</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_width"
                                                   id="option_{{$i}}_width"
                                                   placeholder="Ширина">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_{{$i}}_height">Высота</label>
                                            <input type="text" class="form-control" name="option_{{$i}}_height"
                                                   id="option_{{$i}}_height"
                                                   placeholder="Высота">
                                        </div>
                                    </div>
                                @endfor
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-block">Сохранить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="panel-body">
                            Ошибка!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop