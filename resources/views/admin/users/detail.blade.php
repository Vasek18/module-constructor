@extends("admin.template")

@section("page")
    <h1>{{ $user->last_name }} {{ $user->first_name }}</h1>
    <div class="row">
        <div class="col-md-5">
            <p>Зарегистрировался: {{ $user->created_at }}</p>
            <form action="{{ action('Admin\AdminUsersController@update', [$user]) }}"
                  class="form"
                  method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="payed_days">Оплаченных дней</label>
                    <input type="text"
                           id="payed_days"
                           name="payed_days"
                           class="form-control"
                           value="{{ $user->payed_days }}">
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
@stop