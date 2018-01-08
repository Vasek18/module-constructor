@extends('bitrix.internal_template')

@section('h1')
    Шаблон "{{ $template->name }}" ({{ $template->code }})
@stop

@section('page')
    @if (count($templateFiles))
        <h2>Файлы</h2>
        <ul class="list-group">
            @foreach($templateFiles as $file)
                <li class="list-group-item">{{ $file }}</li>
            @endforeach
        </ul>
    @endif
@stop