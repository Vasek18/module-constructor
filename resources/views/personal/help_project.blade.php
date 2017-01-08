@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h2>{{ trans('personal_cabinet.help_project_h1') }}</h2>
        @include('donate_form')
    </div>
@stop