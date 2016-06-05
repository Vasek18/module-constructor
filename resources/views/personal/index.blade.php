@extends("app")

@section("content")
    <div class="container">
        <h1>{{trans('personal_index.personal_cabinet')}}</h1>
        <hr>
        <h2>{{trans('personal_index.modules_list')}}</h2>
        @include('personal.bitrix_block')
    </div>
@stop