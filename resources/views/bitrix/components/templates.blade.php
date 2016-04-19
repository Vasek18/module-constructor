@extends('bitrix.internal_template')

@section('h1')
    Шаблоны | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

@stop
