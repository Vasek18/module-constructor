@extends('bitrix.internal_template')

@section('h1')
    Хранение данных
@stop

@section('page')

    <h2>Инфоблоки</h2>
    <a href="{{action('Modules\Bitrix\BitrixDataStorageController@add_ib', [$module->id])}}" class="btn btn-primary">Добавить
        иб</a>
    <br>
    <br>
    @if (count($infoblocks))
        <ul>
            @foreach($infoblocks as $infoblock)
                <li>
                    Инфоблок {{$infoblock->name}} ({{$infoblock->code}})
                    <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $infoblock->id]) }}"
                       class="btn btn-primary">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-danger"
                       href="{{ action('Modules\Bitrix\BitrixDataStorageController@delete_ib', [$module->id, $infoblock->id]) }}">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a></li>
            @endforeach
        </ul>
    @endif
@stop