@extends('bitrix.internal_template')

@section('h1')
    Компоненты
@stop

@section('page')
    <a href="{{ route('bitrix_new_component', $module->id) }}" class="btn btn-primary">Добавить
        компонент
    </a>
    @include('bitrix.components.upload_zip_window', ['module' => $module])
    <hr>
    @if (count($components))
        <h2>Компоненты</h2>
        <div class="list-group">
            @foreach($components as $component)
                <div class="list-group-item clearfix component">
                    <a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">
                        Компонент
                        "{{$component->name}}" ({{$component->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsController@destroy', [$module->id, $component->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop