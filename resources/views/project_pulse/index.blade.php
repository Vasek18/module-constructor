@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <h1>{{ trans('project_pulse.h1') }}</h1>
            <p class="big-text">{!! trans('project_pulse.desc', ['href'=>action('FunctionalSuggestionController@index')]) !!}</p>
            @foreach($posts as $post)
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
            <div class="text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@stop