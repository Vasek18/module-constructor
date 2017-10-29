@extends("app")

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ action('Admin\AdminController@index') }}"
                       class="list-group-item">
                        Главная
                    </a>
                    <a href="{{ action('Admin\AdminUsersController@index') }}"
                       class="list-group-item">
                        Пользователи
                    </a>
                    <a href="{{ action('Admin\AdminController@modules') }}"
                       class="list-group-item">Модули
                    </a>
                    <a href="{{ action('Admin\AdminPaymentsController@index') }}"
                       class="list-group-item">Оплаты
                    </a>
                    <a href="{{ action('Admin\AdminSettingsController@index') }}"
                       class="list-group-item">Основные настройки сервиса
                    </a>
                    <a class="list-group-item list-group-item-info"
                       role="button"
                       data-toggle="collapse"
                       href="#bitrixSubMenu"
                       aria-expanded="false"
                       aria-controls="bitrixSubMenu">
                        Для модулей Битрикса
                    </a>
                    <div class="collapse"
                         id="bitrixSubMenu">
                        <a href="{{ action('Admin\AdminConfirmsController@index') }}"
                           class="list-group-item">На утверждение
                        </a>
                        <a href="{{ action('Admin\AdminClassPhpTemplatesController@index') }}"
                           class="list-group-item">Шаблоны class.php
                        </a>
                    </div>
                    <a class="list-group-item list-group-item-info"
                       role="button"
                       data-toggle="collapse"
                       href="#publicTexts"
                       aria-expanded="false"
                       aria-controls="publicTexts">
                        Статьи и новости
                    </a>
                    <div class="collapse"
                         id="publicTexts">
                        <a href="{{ action('Admin\AdminController@articles') }}"
                           class="list-group-item">Статьи
                        </a>
                        <a href="{{ action('Admin\AdminProjectPulseController@index') }}"
                           class="list-group-item">Пульс проекта
                        </a>
                    </div>
                    <a class="list-group-item list-group-item-info"
                       role="button"
                       data-toggle="collapse"
                       href="#serviceImprovement"
                       aria-expanded="false"
                       aria-controls="serviceImprovement">
                        Работа с ошибками сервиса
                    </a>
                    <div class="collapse"
                         id="serviceImprovement">
                        <a href="{{ action('Admin\AdminLogsController@index') }}"
                           class="list-group-item">Логи
                        </a>
                        <a href="{{ action('Admin\AdminUserReportsController@index') }}"
                           class="list-group-item">Репорты
                        </a>
                    </div>
                    <a class="list-group-item {!! classActiveSegment(2, 'metrics') !!}"
                       href="{{ action('Admin\AdminMetricsEventsLogController@index') }}">
                        Метрики
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('page')
            </div>
        </div>
    </div>
@stop