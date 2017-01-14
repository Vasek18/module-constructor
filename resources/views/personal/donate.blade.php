@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h1>{{ trans('personal_cabinet.donate_h1') }}</h1>
        <p class="lead">{!! trans('personal_cabinet.donate_p') !!}</p>
        @include('donate_form')
        <p class="lead">{!! trans('personal_cabinet.donate_p_after') !!}</p>
    </div>
@stop