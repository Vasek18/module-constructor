<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Конструктор модулей</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrap">
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#top-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Конструктор модулей</a>
                </div>
                <div class="collapse navbar-collapse" id="top-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        @if (!Auth::check())
                            <li><a href="{{ route('auth') }}">Авторизация</a></li>
                            <li><a href="{{ route('reg') }}">Регистрация</a></li>
                        @else
                            <li><a href="{{ route('personal') }}">Личный кабинет</a></li>
                            <li><a href="{{ route('logout') }}">Выйти</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @yield("content")
    <div id="push"></div>
</div>
<footer>
    <div class="creator">
        <a href="http://aristov-vasiliy.ru/">Разработчик сервиса Аристов Василий</a>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<script src="/js/app.js"></script>
@stack('scripts')
</body>
</html>