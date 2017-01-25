@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <h1>{{ trans('project_help.h1') }}</h1>
            <p class="big-text">{!! trans('project_help.first_p') !!}</p>
            <h2>{{ trans('project_help.non_material_help_title') }}</h2>
            <p class="big-text">{!! trans('project_help.non_material_help_p') !!}</p>
            <p class="big-text">{!! trans('project_help.we_collect_information') !!}</p>
            <ul>
                <li>
                    <a href="{{ action('ProjectHelpController@bitrixEvents') }}"
                       class="big-text">{{ trans('project_help.bitrix_events_list') }}
                    </a>
                </li>
            </ul>
            <h2>{{ trans('project_help.material_help_title') }}</h2>
            <p class="big-text">{!! trans('project_help.material_help_p') !!}</p>
            @include('donate_form')
            <h2>{{ trans('project_help.any_other_ideas') }}</h2>
            <p class="big-text">{!! trans('project_help.write_your_ideas') !!}
                <a href="mailto:{{ env('PUBLIC_EMAIL') }}"><b>{{ env('PUBLIC_EMAIL') }}</b></a>
                .
            </p>
        </div>
    </div>
@stop