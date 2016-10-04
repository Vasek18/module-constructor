@extends("admin.template")

@section("page")
    <h1>Пользователи</h1>
    <h2>Всего пользователей:
        <span class="userCount">{{ $usersCount }}</span>
    </h2>
@stop