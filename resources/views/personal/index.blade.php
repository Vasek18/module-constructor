@extends("app")

@section("content")
    <div class="container">
        <h1>{{ Auth::user()->last_name }} {{  Auth::user()->first_name }}
            <small>({{ trans('personal_index.payed_days') }}: {{  Auth::user()->payed_days }})</small>
        </h1>
        <hr>
        <h2>{{trans('personal_index.modules_list')}}</h2>
        @include('personal.bitrix_block')
    </div>
@stop