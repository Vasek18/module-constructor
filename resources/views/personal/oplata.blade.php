@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h2>{{ trans('personal_cabinet.oplata_h1') }}</h2>
        @include('personal.oplata_form')
    </div>
@stop