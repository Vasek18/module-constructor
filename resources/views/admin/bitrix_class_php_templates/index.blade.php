@extends("admin.template")

@section("page")
    <h1>Шаблоны class.php</h1>
    <h2>Добавить шаблон</h2>
    @if (count($public_templates))
        <h2>Все общие шаблоны</h2>
        @foreach($public_templates as $public_template)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $public_template->name }}</div>
                <div class="panel-body">
                    {{ $public_template->template }}
                </div>
            </div>
        @endforeach
    @endif
    <a class="btn btn-primary"
       href="{{ action('Admin\AdminClassPhpTemplatesController@private_ones') }}">Частные шаблоны
        <span class="glyphicon glyphicon-arrow-right"
              aria-hidden="true"></span>
    </a>
@stop