@extends("admin.template")

@section("page")
    <h1>Пользователи</h1>
    <h2>Всего пользователей:
        <span class="userCount">{{ $usersCount }}</span>
    </h2>
    <div class="list-group">
        @foreach($users as $user)
            <a href="{{ action('Admin\AdminUsersController@show', ['user' => $user]) }}"
               class="list-group-item">
                <div class="clearfix">
                    <div class="col-md-8">
                        {{ $user->last_name }} {{ $user->first_name }} ({{ $user->email }})
                    </div>
                    <div class="col-md-3">
                        {{ $user->visits()->first()?'Заходил '.$user->visits()->last()->first()->login_at:'' }}
                    </div>
                    <div class="col-md-1">
                        <span class="badge">{{ $user->modules->count() }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@stop