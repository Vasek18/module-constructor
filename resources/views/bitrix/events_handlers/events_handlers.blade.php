@extends('bitrix.internal_template')

@section('h1')
    Привязка к событиям
@stop

@section('page')
    <form role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixEventHandlersController@store', $module->id) }}">
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
            @include('bitrix.events_handlers.item', ['handler' => $handler, 'i' => $i, 'module' => $module])
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($handlers); $j < count($handlers)+5; $j++)
            @include('bitrix.events_handlers.item', ['handler' => null, 'i' => $j, 'module' => $module])
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>
@stop