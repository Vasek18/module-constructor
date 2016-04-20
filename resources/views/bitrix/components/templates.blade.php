@extends('bitrix.internal_template')

@section('h1')
    Шаблоны | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    @include('bitrix.components.create_template')


    <h2>Шаблоны</h2>

    @if ($templates)
        <ul>
            @foreach($templates as $template)
                <li>{{$template->name}} ({{$template->code}})</li>
            @endforeach
        </ul>
    @endif

@stop
