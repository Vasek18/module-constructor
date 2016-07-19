@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.templates_h1') }} | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    <a class="btn btn-primary" href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@create', [$module->id, $component->id]) }}">{{ trans('bitrix_components.templates_button_create') }}
    </a>

    @include('bitrix.components.templates.create_modal')

    @if ($templates)
        <h2>{{ trans('bitrix_components.templates_list') }}</h2>
        <div class="list-group">
            @foreach($templates as $template)
                <div class="list-group-item clearfix template">
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@show', [$module->id, $component->id, $template->id]) }}">{{$template->code}} {{$template->name?'('.$template->name.')':$template->name}}</a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@destroy', [$module->id, $component->id, $template->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

@stop
