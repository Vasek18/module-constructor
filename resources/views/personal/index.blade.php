@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h2>{{trans('personal_index.modules_list')}}</h2>
        @include('personal.bitrix_block')
    </div>
@stop