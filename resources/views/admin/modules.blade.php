@extends("admin.template")

@section("page")
    <h1>Модули</h1>
    <h2>Битрикс ({{ $bitrixes->count() }})</h2>
    <div class="list-group">
        @foreach($bitrixes as $bitrix)
            <div class="list-group-item clearfix">
                <a href="{{ action('Admin\AdminController@modulesDetail', ['bitrix' => $bitrix]) }}"
                   class="pull-left">{{ $bitrix->name }} {{ $bitrix->code }}</a>
                <a href="{{ action('Admin\AdminController@usersDetail', ['user' => $user]) }}"
                   class="pull-right">{{ $bitrix->creator->name }}</a>
            </div>
        @endforeach
    </div>
@stop