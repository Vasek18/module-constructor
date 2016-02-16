@extends('bitrix.internal_template')

@section('h1')
    Компоненты
@stop

@section('page')
    <a href="{{ route('bitrix_new_component', $module->id) }}" class="btn btn-primary">Добавить
        компонент</a>
    <br>
    <br>
    <div class="list-group">
        @foreach($components as $component)
            <a class="list-group-item" href="#">Компонент "{{$module->MODULE_NAME}}"</a>
        @endforeach
    </div>
@stop