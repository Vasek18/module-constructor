@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('bitrix.menu')
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">Привязка к событиям | Модуль "{{$module->MODULE_NAME}}"
                            ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST"
                                  action="{{ action('Modules\BitrixController@events_handlers_save', $module->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row option-headers">
                                    <div class="col-md-3">
                                        <label>Событие</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Класс для обработчика</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Метод для обработчика</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Код обработчика</label>
                                    </div>
                                </div>
                                @foreach($handlers as $i => $handler)
                                    <div class="row option">
                                        <div class="col-md-3">
                                            <label class="sr-only" for="event_{{$i}}">Событие</label>
                                            <input type="text" class="form-control" name="event[]"
                                                   id="event_{{$i}}"
                                                   placeholder="Событие" value="{{$handler->event}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="class_{{$i}}">Класс для обработчика</label>
                                            <input type="text" class="form-control" name="class_{{$i}}"
                                                   id="class_{{$i}}"
                                                   placeholder="Класс для обработчика" value="{{$handler->class}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="method_{{$i}}">Метод для обработчика</label>
                                            <input type="text" class="form-control" name="method_{{$i}}"
                                                   id="method_{{$i}}"
                                                   placeholder="Метод для обработчика" value="{{$handler->method}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="sr-only" for="php_code_{{$i}}">Код для обработчика</label>
                                            <textarea class="form-control" name="php_code_{{$i}}"
                                                      id="php_code_{{$i}}"
                                                      placeholder="Код для обработчика"
                                                      rows="10">{{$handler->php_code}}</textarea>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="{{ action('Modules\BitrixController@events_handler_delete', [$module->id, $handler->id]) }}"
                                               class="btn btn-danger">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Дополнительно показываем ещё несколько пустых строк --}}
                                @for ($j = count($handlers); $j < count($handlers)+5; $j++)
                                    <div class="row option">
                                        <div class="col-md-3">
                                            <label class="sr-only" for="event_{{$j}}">Событие</label>
                                            <input type="text" class="form-control" name="event[]"
                                                   id="event_{{$j}}"
                                                   placeholder="Событие"
                                                    >
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="class_{{$j}}">Класс для обработчика</label>
                                            <input type="text" class="form-control" name="class_{{$j}}"
                                                   id="class_{{$j}}"
                                                   placeholder="Класс для обработчика"
                                                    >
                                        </div>
                                        <div class="col-md-2">
                                            <label class="sr-only" for="method_{{$j}}">Метод для обработчика</label>
                                            <input type="text" class="form-control" name="method_{{$j}}"
                                                   id="method_{{$j}}"
                                                   placeholder="Метод для обработчика"
                                                    >
                                        </div>
                                        <div class="col-md-4">
                                            <label class="sr-only" for="php_code_{{$j}}">Код для обработчика</label>
                                            <textarea class="form-control" name="php_code_{{$j}}"
                                                      id="php_code_{{$j}}"
                                                      rows="10">
                                                </textarea>
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