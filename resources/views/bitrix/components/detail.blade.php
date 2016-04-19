@extends('bitrix.internal_template')

@section('h1')
    Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')
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
    @include('bitrix.components.files', ['module' => $module, 'component' => $component])
@stop
