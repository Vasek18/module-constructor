@extends('app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>{{ trans('error_pages.404_h1') }}</h1>
            <p>{{ trans('error_pages.404_text') }}</p>
        </div>
    </div>
@stop