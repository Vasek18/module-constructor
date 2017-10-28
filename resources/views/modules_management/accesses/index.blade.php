@extends('modules_management.internal_template')

@section('h1')
    Доступы
@stop

@section("page")
    <form action="{{ action('Modules\Management\ModulesAccessesController@index', $module->id) }}"
          method="post">
        {{ csrf_field() }}
        @foreach($accesses as $access_email => $access_permissions)
            @include('modules_management.accesses.item', ['i' => $loop->index, 'access_email' => $access_email, 'access_permissions' => $access_permissions, 'permissions' => $permissions])
        @endforeach
        @for($i = count($accesses); $i < count($accesses) + 2; $i++)
            @include('modules_management.accesses.item', ['i' => $i, 'access_email' => '', 'access_permissions' => [], 'permissions' => $permissions])
        @endfor
        <div class="form-group">
            <button id="save"
                    name="save"
                    class="btn btn-success">Сохранить
            </button>
        </div>
    </form>
    <hr>
    <p>На это странице вы можете предоставить доступы к модулям другим пользователям сервиса.<br>
        При задании нового доступа на указанный емеил придёт письмо.<br>
        В случае, если пользователь с таким емеилом ещё не зарегистрирован в системе, ему будет предложено пройти регистрацию.
    </p>
@stop