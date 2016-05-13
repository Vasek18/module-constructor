@extends('bitrix.internal_template')

@section('h1')
    Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')
    @include('bitrix.components.progress_way_menu')
    <div class="row">
        <h2>Информация</h2>
        <div class="col-md-3">
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
        </div>
        <div class="col-md-1 col-md-offset-8">
            <a href="{{ action('Modules\Bitrix\BitrixComponentsController@destroy', [$module->id, $component->id]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        </div>
    </div>
@stop
