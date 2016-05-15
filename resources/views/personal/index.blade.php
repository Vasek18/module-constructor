@extends("app")

@section("content")
    <div class="container">
        <h1>Личный кабинет</h1>
        <hr>
        <h2>Список модулей</h2>
        @include('personal.bitrix_block')
    </div>
@stop