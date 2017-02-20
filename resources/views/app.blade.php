<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>@yield('title', trans('app.meta_title'))</title>
    <meta name="keywords"
          content="@yield('keywords')">
    <meta name="description"
          content="@yield('description', trans('app.meta_description'))">
    <meta name="yandex-verification"
          content="8efd6448266108e3"/>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="/css/app.css">
    @stack('styles')
    <link href='https://fonts.googleapis.com/css?family=Lato:100,400,700,900'
          rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <meta property="og:title"
          content="{{ trans('app.meta_title') }}"/>
    <meta property="og:description"
          content="{{ trans('app.meta_description') }}"/>
    <meta property="og:url"
          content="{{ url()->current() }}"/>
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
                       href="/">{{trans('app.site_name')}} (beta)
                    </a>
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
                                @if (setting('day_price'))
                                    <li>
                                        <a href="/oplata/">{{ trans('app.link_to_oplata') }}</a>
                                    </li>
                                @endif
                                @if (setting('donat'))
                                    <li>
                                        <a href="/does_it_charge/">{{ trans('app.link_to_should_i_pay') }}</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="/contacts/">{{ trans('app.link_to_contacts') }}</a>
                                </li>
                                <li>
                                    <a href="/requisites/">{{ trans('app.link_to_requisites') }}</a>
                                </li>
                            </ul>
                        </li>
                        @if (isset($about_service_articles) && $about_service_articles->count())
                            <li class="dropdown">
                                <a href="use_cases"
                                   class="dropdown-toggle"
                                   data-toggle="dropdown"
                                   role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">{{ trans('app.link_to_about_service_articles_title') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($about_service_articles->get() as $article)
                                        <li>
                                            <a href="{{ $article->link }}">{{ $article->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (!Auth::check())
                            <li>
                                <a href="{{ route('login') }}">{{trans('app.link_to_auth_title')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">{{trans('app.link_to_reg_title')}}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('personal') }}">{{trans('app.link_to_personal_title')}}</a>
                            </li>
                            <li>
                                <form method="POST"
                                      action="{{ route('logout') }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-link">{{trans('app.link_to_logout_title')}}</button>
                                </form>
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
        <div class="row">
            <div class="footer-menu col-md-3 col-md-offset-1">
                <nav>
                    <ul>
                        <li>
                            <a href="{{ action('ProjectHelpController@index') }}">{{ trans('app.link_project_help_title') }}</a>
                        </li>
                        <li>
                            <a href="{{ action('FunctionalSuggestionController@index') }}">{{ trans('app.link_functional_suggestions_title') }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="footer-menu col-md-3 col-md-offset-5">
                <a href="{{ action('ProjectPulsePostController@index') }}">{{ trans('app.link_project_pulse_title') }}</a>
                @include('scoset_share')
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
<script src="/js/deletion_with_confirm.js"></script>
<script src="/js/human_ajax_deletion.js"></script>
<script src="/js/app.js"></script>
@stack('scripts')
@include('flash')
@include('yandex_metrika')
@include('delete_confirm_modal')
</body>
</html>