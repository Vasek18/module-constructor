@extends('bitrix.internal_template')

@section('h1')
    Привязка к событиям
@stop

@section('page')
    <form role="form" method="POST"
          action="{{ action('Modules\BitrixEventHandlersController@store', $module->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row option-headers">
            <div class="col-md-2">
                <label>Модуль генерирующий событие</label>
            </div>
            <div class="col-md-2">
                <label>Событие</label>
            </div>
            <div class="col-md-2">
                <label>Класс для обработчика</label>
            </div>
            <div class="col-md-2">
                <label>Метод для обработчика</label>
            </div>
            <div class="col-md-3">
                <label>Код обработчика</label>
            </div>
        </div>
        @foreach($handlers as $i => $handler)
            <div class="row option">
                <div class="col-md-2">
                    <label class="sr-only" for="from_module_{{$i}}">Модуль</label>
                    <input type="text" class="form-control" name="from_module_{{$i}}"
                           id="from_module_{{$i}}"
                           placeholder="Модуль" value="{{$handler->from_module}}">
                </div>
                <div class="col-md-2">
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
                <div class="col-md-3">
                    <a href="#" class="btn btn-default" data-toggle="modal"
                       data-target="#php_code_{{$i}}">Редактировать</a>
                    <div class="modal fade" tabindex="-1" role="dialog" id="php_code_{{$i}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Код для обработчика</h4>
                                </div>
                                <div class="modal-body">
                                    <label class="sr-only" for="php_code_{{$i}}">Код для обработчика</label>
                                            <textarea class="form-control" name="php_code_{{$i}}"
                                                      id="php_code_{{$i}}"
                                                      placeholder="Код для обработчика"
                                                      rows="100">{{$handler->php_code}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="{{ action('Modules\BitrixEventHandlersController@destroy', [$module->id, $handler->id]) }}"
                       class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($handlers); $j < count($handlers)+5; $j++)
            <div class="row option">
                <div class="col-md-2">
                    <label class="sr-only" for="from_module_{{$j}}">Модуль</label>
                    <input type="text" class="form-control" name="from_module_{{$j}}"
                           id="from_module_{{$j}}"
                           placeholder="Модуль"
                            >
                </div>
                <div class="col-md-2">
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
                <div class="col-md-3">
                    <a href="#" class="btn btn-default" data-toggle="modal"
                       data-target="#php_code_{{$j}}">Редактировать</a>
                    <div class="modal fade" tabindex="-1" role="dialog" id="php_code_{{$j}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Код для обработчика</h4>
                                </div>
                                <div class="modal-body">
                                    <label class="sr-only" for="php_code_{{$j}}">Код для обработчика</label>
                                            <textarea class="form-control" name="php_code_{{$j}}"
                                                      id="php_code_{{$j}}"
                                                      placeholder="Код для обработчика"
                                                      rows="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>
@stop