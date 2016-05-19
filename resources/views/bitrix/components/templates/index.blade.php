@extends('bitrix.internal_template')

@section('h1')
    Шаблоны | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    @include('bitrix.components.templates.create_modal')


    <h2>Шаблоны</h2>

    @if ($templates)
        <ul>
            @foreach($templates as $template)
                <li>
                    <p>{{$template->name}} ({{$template->code}})</p>
                    <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@destroy', [$module->id, $component->id, $template->id]) }}" class="btn btn-danger">Удалить</a>
                </li>
            @endforeach
        </ul>
    @endif

@stop
