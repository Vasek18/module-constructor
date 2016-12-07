@extends('app')

@section('content')
    <div class="container">
        <h1>{{ trans('contacts.h1') }}</h1>
        <p class="big-text">{{ trans('contacts.my_email') }} <b>admin@modules-constructor.ru</b></p>
        <p class="big-text">{!! trans('contacts.use_forms') !!}</p>
    </div>
@stop