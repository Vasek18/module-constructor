@extends("admin.template")

@section("page")
    <a class="btn btn-primary"
       href="{{ action('Admin\AdminClassPhpTemplatesController@index') }}">
        <span class="glyphicon glyphicon-arrow-left"
              aria-hidden="true"></span>
        Общие шаблоны
    </a>
    @if (count($private_templates))
        <h1>Все частные шаблоны</h1>
        @foreach($private_templates as $private_template)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $private_template->name }}</div>
                <div class="panel-body">
                    {{ $private_template->template }}
                </div>
            </div>
        @endforeach
    @endif
@stop