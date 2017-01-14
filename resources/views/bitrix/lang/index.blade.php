@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_lang.h1') }}
@stop

@section('page')

    @if(count($files))
        <h2>{{ trans('bitrix_lang.all_files') }}</h2>
        <ul class="list-group">
            @foreach($files as $file)
                <li class="list-group-item {{ $file["is_there_potential_phrase"]?'list-group-item-danger':'' }}">
                    <a href="{{ action('Modules\Bitrix\BitrixLangController@edit', [$module->id]) }}?file={{urlencode($file["file"])}}">{{ $file["file"] }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <hr>
    <p class="description">{!! trans('bitrix_lang.step_description') !!}</p>
@stop