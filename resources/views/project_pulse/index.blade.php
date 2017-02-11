@extends("app")

@section("content")
    <div class="container">
        <div class="row">
            <h1>{{ trans('project_pulse.h1') }}</h1>
            <p class="big-text">{!! trans('project_pulse.desc') !!}</p>
            @foreach($posts as $post)
                <div class="panel panel-{{ $post->highlight?'primary':'default' }}">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $post->name }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ $post->description }}
                    </div>
                    <div class="panel-footer">{{ $post->created_at }}</div>
                </div>
            @endforeach
        </div>
    </div>
@stop