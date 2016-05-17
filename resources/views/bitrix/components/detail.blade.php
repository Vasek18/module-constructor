@extends('bitrix.internal_template')

@section('h1')
    Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')
    @include('bitrix.components.progress_way_menu')
    <h2>Информация</h2>
    <div class="col-md-11">
        <form method="post"
              action="{{ action('Modules\Bitrix\BitrixComponentsController@update', [$module->id, $component->id]) }}"
              class="readonly">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>Код</label>
                <p class="form-control-static">{{$component->code}}</p>
            </div>
            <div class="form-group">
                <label for="name">Название</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax" data-name="name"
                       data-pattern="[a-zA-Zа-яА-Я0-9]*">{{$component->name}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="desc">Описание</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax {{$component->desc?:'not-exist'}}" data-name="desc"
                       data-formtype="textarea">{{$component->desc?$component->desc:'Отсутствует'}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax" data-name="sort">{{$component->sort}}</a>
                </p>
            </div>
            <button type="submit" class="hidden">Сохранить</button>
        </form>
    </div>
    <div class="col-md-1">
        <a href="{{ action('Modules\Bitrix\BitrixComponentsController@destroy', [$module->id, $component->id]) }}"
           class="btn btn-danger">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </a>
    </div>
@stop
