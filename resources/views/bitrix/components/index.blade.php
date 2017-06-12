@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.h1') }}
@stop

@section('page')
    <a href="{{ route('bitrix_new_component', $module->id) }}"
       class="btn btn-primary">{{ trans('bitrix_components.button_add') }}
    </a>
    @include('bitrix.components.upload_zip_window', ['module' => $module])
    <hr>
    @if (count($components))
        <h2>{{ trans('bitrix_components.components') }}</h2>
        <div class="list-group">
            @foreach($components as $component)
                <div class="list-group-item clearfix component deletion_wrapper">
                    <a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">
                        {{ trans('bitrix_components.component') }} "{{$component->name}}" ({{$component->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsController@destroy', [$module->id, $component->id]) }}"
                       class="btn btn-danger pull-right deletion-with-confirm"
                       id="delete_component_{{$component->id}}">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop