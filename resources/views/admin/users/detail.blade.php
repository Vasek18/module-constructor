@extends("admin.template")

@section("page")
    <div class="row">
        <div class="col-md-5">
            <h1>{{ $user->last_name }} {{ $user->first_name }}
                <a href="{{ action('Admin\AdminUsersController@destroy', [$user]) }}"
                   class="btn btn-danger"
                   id="deleteUser">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                </a>
            </h1>
            <p>Зарегистрировался: {{ $user->created_at }}</p>
            <form action="{{ action('Admin\AdminUsersController@update', [$user]) }}"
                  class="form"
                  method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="paid_days">Оплаченных дней</label>
                    <input type="text"
                           id="paid_days"
                           name="paid_days"
                           class="form-control"
                           value="{{ $user->paid_days }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"
                            name="save">Сохранить
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <h2>Модули на Битриксе</h2>
            <div class="list-group">
                @foreach($bitrixes as $bitrix)
                    <a href="{{ action('Admin\AdminController@modulesDetail', ['bitrix' => $bitrix]) }}"
                       class="list-group-item">
                        {{ $bitrix->name }} ({{ $bitrix->full_id }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            Заходил: {{ $user->getLastLogin()?$user->getLastLogin()->login_at:'' }}
            <br> С ip: {{ $user->getLastLogin()?$user->getLastLogin()->ip:'' }}
        </div>
    </div>
@stop