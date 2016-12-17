@extends("admin.template")

@section("page")

    <div class="row">
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $usersCount?:0 }}</h1>
                <p>Пользователей</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $modulesCount?:0 }}</h1>
                <p>Модулей</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $earnedRubles?:0 }}</h1>
                <p>Рублей заработано</p>
            </div>
        </div>
    </div>


@stop