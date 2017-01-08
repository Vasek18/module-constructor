@extends("app")

@section("content")
    <h1>{{ Auth::user()->last_name }} {{  Auth::user()->first_name }}
        @if (setting('day_price'))
            <small>({{ trans('personal_index.paid_days') }}: {{  Auth::user()->paid_days }})</small>
        @endif
    </h1>
    <hr>
    <div class="container">
        @include('personal.header')
        <h2>{{trans('personal_index.modules_list')}}</h2>
        @include('personal.bitrix_block')
    </div>
@stop