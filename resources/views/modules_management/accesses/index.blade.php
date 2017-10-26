@extends('modules_management.internal_template')

@section('h1')
    Доступы
@stop

@section("page")
    <form action="{{ action('Modules\Management\ModulesAccessesController@index', $module->id) }}"
          method="post">
        {{ csrf_field() }}
        @foreach($accesses as $access_email => $access_permissions)
            @include('modules_management.accesses.item', ['access_email' => $access_email, 'access_permissions' => $access_permissions, 'permissions' => $permissions])
        @endforeach
        @for($i = 0; $i<2; $i++)
            @include('modules_management.accesses.item', ['access_email' => '', 'access_permissions' => [], 'permissions' => $permissions])
        @endfor
        <div class="form-group">
            <button id="save"
                    name="save"
                    class="btn btn-success">Сохранить
            </button>
        </div>
    </form>
@stop