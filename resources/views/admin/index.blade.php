@extends("admin.template")

@section("page")

    <div class="row">
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $usersCount }}</h1>
                <p>Пользователей</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $modulesCount }}</h1>
                <p>Модулей</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron">
                <h1>{{ $earnedRubles }}</h1>
                <p>Рублей заработанно</p>
            </div>
        </div>
    </div>


@stop