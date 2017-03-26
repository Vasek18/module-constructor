@extends("admin.template")

@section("page")
    <h1>Пользователи</h1>
    <h2>Всего пользователей:
        <span class="userCount">{{ $usersCount }}</span>
    </h2>
    <div class="list-group">
        @foreach($users as $user)
            <div class="list-group-item">
                <div class="clearfix">
                    <div class="col-md-7">
                        <a href="{{ action('Admin\AdminUsersController@show', ['user' => $user]) }}">
                            {{ $user->last_name }} {{ $user->first_name }} ({{ $user->email }})
                        </a>
                    </div>
                    <div class="col-md-3">
                        {{ $user->getLastLogin()?'Заходил '.$user->getLastLogin()->login_at:'' }}
                    </div>
                    <div class="col-md-1">
                        <span class="badge">{{ $user->modules->count() }}</span>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ action('Admin\AdminUsersController@destroy', [$user]) }}"
                           id="delete{{ $user->id }}"
                           class="btn btn-danger btn-sm deletion-with-confirm">
                             <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop