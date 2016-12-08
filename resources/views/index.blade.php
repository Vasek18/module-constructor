@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="welcome-block">
                <h1>{!! trans('home.welcome_header') !!}</h1>
                <p>{!! trans('home.welcome_p') !!}</p>
                <p>
                    <a class="btn btn-success btn-lg"
                       href="{{ action('Auth\AuthController@index_reg') }}"
                       role="button">{!! trans('home.welcome_action') !!}
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
    </div>
@stop