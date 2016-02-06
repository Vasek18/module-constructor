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
                            <form class="">
                                @foreach($options as $option)
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_id">ID</label>
                                            <input type="text" class="form-control" name="option_1_id" id="option_1_id"
                                                   placeholder="ID">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_name">Название</label>
                                            <input type="text" class="form-control" name="option_1_name"
                                                   id="option_1_name"
                                                   placeholder="Название">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_type">Тип</label>
                                            <select class="form-control" name="option_1_type" id="option_1_type">
                                                <option value="">Выберите тип</option>
                                                @foreach($optionsTypes as $type)
                                                    <option value="">{{$type->NAME_RU}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_width">Ширина</label>
                                            <input type="text" class="form-control" name="option_1_width"
                                                   id="option_1_width"
                                                   placeholder="Ширина">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_height">Высота</label>
                                            <input type="text" class="form-control" name="option_1_height"
                                                   id="option_1_height"
                                                   placeholder="Высота">
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Дополнительно показываем ещё несколько пустых строк --}}
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_id">ID</label>
                                            <input type="text" class="form-control" name="option_1_id" id="option_1_id"
                                                   placeholder="ID">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_name">Название</label>
                                            <input type="text" class="form-control" name="option_1_name"
                                                   id="option_1_name"
                                                   placeholder="Название">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_type">Тип</label>
                                            <select class="form-control" name="option_1_type" id="option_1_type">
                                                <option value="">Выберите тип</option>
                                                @foreach($optionsTypes as $type)
                                                    <option value="">{{$type->NAME_RU}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_width">Ширина</label>
                                            <input type="text" class="form-control" name="option_1_width"
                                                   id="option_1_width"
                                                   placeholder="Ширина">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="option_1_height">Высота</label>
                                            <input type="text" class="form-control" name="option_1_height"
                                                   id="option_1_height"
                                                   placeholder="Высота">
                                        </div>
                                    </div>
                                @endfor
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