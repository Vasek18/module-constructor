@extends('bitrix.internal_template')

@section('h1')
    Хранение данных
@stop

@section('page')

    <h2>Инфоблоки</h2>
    <a href="{{action('Modules\Bitrix\BitrixDataStorageController@add_ib', [$module->id])}}" class="btn btn-primary">Добавить иб</a>

@stop