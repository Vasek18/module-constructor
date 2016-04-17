@extends('bitrix.internal_template')

@section('h1')
    Компонент
@stop

@section('page')
    <h2>Информация</h2>
    <dl>
        <dt>Название</dt>
        <dd>{{$component->name}}</dd>
        <dt>Код</dt>
        <dd>{{$component->code}}</dd>
        <dt>Описание</dt>
        <dd>{{$component->desc}}</dd>
        <dt>Сортировка</dt>
        <dd>{{$component->sort}}</dd>
    </dl>
    @include('bitrix.components.path_items', ['module' => $module, 'component' => $component, 'path_items' => $path_items])
    @include('bitrix.components.files', ['module' => $module, 'component' => $component])
@stop
