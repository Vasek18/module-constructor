@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('page')
    @include('bitrix.components.progress_way_menu')
    <h2>{{ trans('bitrix_components.main_info_title') }}</h2>
    <div class="col-md-11">
        <form method="post"
              action="{{ action('Modules\Bitrix\BitrixComponentsController@update', [$module->id, $component->id]) }}"
              class="readonly">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>{{ trans('bitrix_components.field_component_code') }}</label>
                <p class="form-control-static">{{$component->code}}</p>
            </div>
            <div class="form-group">
                <label>{{ trans('bitrix_components.field_component_namespace') }}</label>
                <p class="form-control-static">{{$component->namespace}}</p>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('bitrix_components.field_component_name') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="name"
                       data-pattern="[a-zA-Zа-яА-Я0-9]*">{{$component->name}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="desc">{{ trans('bitrix_components.field_component_desc') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax {{$component->desc?:'not-exist'}}"
                       data-name="desc"
                       data-formtype="textarea">{{$component->desc?$component->desc:'Отсутствует'}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('bitrix_components.field_component_sort') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="sort">{{$component->sort}}</a>
                </p>
            </div>
            <button type="submit"
                    class="hidden">{{ trans('app.save') }}
            </button>
        </form>
    </div>
    <div class="col-md-1">
        <p>
            <a href="{{ action('Modules\Bitrix\BitrixComponentsController@download', [$module->id, $component->id]) }}"
               class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-download"
                      aria-hidden="true"></span>
                {{ trans('app.download') }}
            </a>
        </p>
        <p>
            <a href="{{ action('Modules\Bitrix\BitrixComponentsController@destroy', [$module->id, $component->id]) }}"
               class="btn btn-sm btn-danger"
               id="delete">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                {{ trans('app.delete') }}
            </a>
        </p>
    </div>
@stop
