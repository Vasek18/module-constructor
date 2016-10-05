@extends("admin.template")

@section("page")
    <h1>Пользователи</h1>
    <h2>Всего пользователей:
        <span class="userCount">{{ $usersCount }}</span>
    </h2>
    <div class="list-group">
        @foreach($users as $user)
            <a href="{{ action('Admin\AdminController@usersDetail', ['user' => $user]) }}"
               class="list-group-item">
                <span class="badge">{{ $user->modules->count() }}</span>
                {{ $user->last_name }} {{ $user->first_name }} ({{ $user->email }})
            </a>
        @endforeach
    </div>
@stop