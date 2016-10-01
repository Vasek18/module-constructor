@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <div class="banner-on-main clearfix">
                <div class="col-md-8">
                    <strong>{{trans('home.little_earnings')}}</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8 col-md-offset-4">
                    <strong>{{trans('home.bitrix_difficult')}}</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8">
                    <strong>{{trans('home.code_repeat')}}</strong>
                </div>
            </div>
            <div class="banner-on-main clearfix">
                <div class="col-md-8 col-md-offset-4">
                    <strong>{{trans('home.stop_it')}}</strong>
                    <p>{!! trans('home.why_stop_it') !!}
                    </p>
                </div>
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