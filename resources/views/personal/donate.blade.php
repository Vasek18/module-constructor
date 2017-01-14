@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h1>{{ trans('personal_cabinet.donate_h1') }}</h1>
        @include('donate_form')
    </div>
@stop