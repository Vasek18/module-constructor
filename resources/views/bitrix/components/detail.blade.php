@extends('bitrix.internal_template')

@section('h1')
    Компонент
@stop

@section('page')
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
@stop

@push('scripts')
@endpush