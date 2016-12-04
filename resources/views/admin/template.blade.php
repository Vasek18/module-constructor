@extends("app")

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ action('Admin\AdminUsersController@index') }}"
                       class="list-group-item">
                        Пользователи
                    </a>
                    <a href="{{ action('Admin\AdminController@modules') }}"
                       class="list-group-item">Модули
                    </a>
                    <a href="#"
                       class="list-group-item">Оплаты
                    </a>
                    <a href="#"
                       class="list-group-item">Рейтинг функционала
                    </a>
                    <a href="{{ action('Admin\AdminSettingsController@index') }}"
                       class="list-group-item">Основные настройки
                    </a>
                    <a href="{{ action('Admin\AdminController@articles') }}"
                       class="list-group-item">Статьи
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('page')
            </div>
        </div>
    </div>
@stop