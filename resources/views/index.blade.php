@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="welcome-block">
                <h1>{!! trans('home.welcome_header') !!}</h1>
                @if (setting('day_price'))
                    <p>{!! trans('home.welcome_p') !!}</p>
                @else
                    <p>{!! trans('home.welcome_p_free') !!}</p>
                @endif
                <p>
                    <a class="btn btn-success btn-lg"
                       href="{{ action('Auth\RegisterController@showRegistrationForm') }}"
                       role="button">{{ trans('home.welcome_action') }}
                    </a>
                    <a class="btn btn-info btn-lg"
                       href="/about/chto_za_servis"
                       role="button">{{ trans('home.about_service_article') }}
                    </a>
                </p>
            </div>
            <div class="col-md-8 col-md-offset-2 project-goal">
                <h2>{{trans('home.project_goal_title')}}</h2>
                <p>{!! trans('home.project_goal_text') !!}</p>
            </div>
            <div class="col-md-8 col-md-offset-2 modules-created">
                <p>{{trans('home.there_were_created')}}</p>
                <strong>{{$countModules}}</strong>
                <p>{{trans_choice('home.modules', $countModules, ['ru_ending' => $modulesEnding])}}</p>
            </div>
        </div>
        @if (count($project_pulse_posts))
            <div class="project-pulse-on-main row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>{{ trans('project_pulse.h1') }}</h2>
                    @foreach($project_pulse_posts as $post)
                        <div class="project-pulse-post panel panel-{{ $post->highlight?'primary':'default' }}">
                            <div class="panel-heading clearfix">
                                <div class="pull-left">
                                    <h3 class="panel-title">{{ $post->name }}</h3>
                                </div>
                                <div class="pull-right">
                                    @if ($user && $user->isAdmin())
                                        <a href="{{ action('ProjectPulsePostController@destroy', [$post->id]) }}"
                                           class="btn btn-sm btn-danger"
                                           id="delete{{ $post->id }}">
                                <span class="glyphicon glyphicon-trash"
                                      aria-hidden="true"></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="panel-body">
                                {{ $post->description }}
                            </div>
                            <div class="panel-footer">{{ $post->created_at }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@stop