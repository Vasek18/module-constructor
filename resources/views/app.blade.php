<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>{{trans('app.site_name')}}</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="/css/app.css">
    @stack('styles')
    <link href='https://fonts.googleapis.com/css?family=Lato:100,400,700,900'
          rel='stylesheet'>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div id="wrap">
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#top-navbar-collapse-1"
                            aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand"
                       href="/">{{trans('app.site_name')}}</a>
                </div>
                <div class="collapse navbar-collapse"
                     id="top-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        @if (!Auth::check())
                            <li>
                                <a href="{{ route('auth') }}">{{trans('app.link_to_auth_title')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('reg') }}">{{trans('app.link_to_reg_title')}}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('personal') }}">{{trans('app.link_to_personal_title')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">{{trans('app.link_to_logout_title')}}</a>
                            </li>
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
    <div class="row footer-actions">
        <div class="col-md-3 col-md-offset-9">
            @include('on_this_page_i_lack_modal')
        </div>
    </div>
    <div class="creator">
        <a href="http://aristov-vasiliy.ru/">{{trans('app.site_developer')}}</a>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<script src="/js/a.you-can-change.js"></script>
{{--<script src="/js/draggable.js"></script>--}}
{{--<script src="/js/jquery.nestable.js"></script>--}}
<script src="/js/translit.js"></script>
<script src="/js/sweetalert.js"></script>
<script src="/js/app.js"></script>
@stack('scripts')
@include('flash')
</body>
</html>