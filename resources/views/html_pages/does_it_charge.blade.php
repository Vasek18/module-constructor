@extends('app')

@section('content')
    <div class="container">
        <h1>{{ trans('does_it_charge.h1') }}</h1>
        <p class="big-text">{!! trans('does_it_charge.p1') !!}</p>
        <p class="big-text">{!! trans('does_it_charge.but_donate') !!}</p>
        @include('donate_form')
    </div>
@stop