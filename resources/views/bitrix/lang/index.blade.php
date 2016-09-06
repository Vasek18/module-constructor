@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_lang.h1') }}
@stop

@section('page')

    @if(count($files))
        <h2>{{ trans('bitrix_lang.all_files') }}</h2>
        <ul>
            @foreach($files as $file)
                <li>
                    <a href="#">{{ $file }}</a>
                </li>
            @endforeach
        </ul>
    @endif

@stop