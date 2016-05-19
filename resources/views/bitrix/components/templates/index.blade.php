@extends('bitrix.internal_template')

@section('h1')
    Шаблоны | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    @include('bitrix.components.templates.create_modal')

    @if ($templates)
        <h2>Шаблоны</h2>
        <div class="list-group">
            @foreach($templates as $template)
                <div class="list-group-item clearfix template">
                    <a href="#">{{$template->name}} ({{$template->code}})</a>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@destroy', [$module->id, $component->id, $template->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

@stop
