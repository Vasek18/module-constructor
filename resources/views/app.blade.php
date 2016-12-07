<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>@yield('title', trans('app.site_name'))</title>
    <meta name="keywords"
          content="@yield('keywords')">
    <meta name="description"
          content="@yield('description')">
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
                    <ul class="nav navbar-nav">
                        @if (isset($use_cases_articles) && $use_cases_articles->count())
                            <li class="dropdown">
                                <a href="use_cases"
                                   class="dropdown-toggle"
                                   data-toggle="dropdown"
                                   role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">{{ trans('app.link_to_use_cases_articles_title') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($use_cases_articles->get() as $article)
                                        <li>
                                            <a href="{{ $article->link }}">{{ $article->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="use_cases"
                               class="dropdown-toggle"
                               data-toggle="dropdown"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false">{{ trans('app.link_to_info') }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/oplata/">{{ trans('app.link_to_oplata') }}</a>
                                </li>
                                <li>
                                    <a href="/contacts/">{{ trans('app.link_to_contacts') }}</a>
                                </li>
                                <li>
                                    <a href="/requisites/">{{ trans('app.link_to_requisites') }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
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
    <div class="container-fluid">
        <div class="row footer-actions">
            <div class="col-md-3 col-md-offset-1">
                @include('i_found_a_bag_modal')
            </div>
            <div class="col-md-3 col-md-offset-5">
                @include('on_this_page_i_lack_modal')
            </div>
        </div>
        <div class="creator">
            <a href="http://aristov-vasiliy.ru/">{{trans('app.site_developer')}}</a>
        </div>
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