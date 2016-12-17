@extends("admin.template")

@section("page")
    <h1>Логи</h1>
    <div class="list-group">
        @foreach($logs as $log)
            <div class="list-group-item">
                <a href="{{ action('Admin\AdminLogsController@show', [$log]) }}">
                    {{ $log }}
                </a>
                <a href="{{ action('Admin\AdminLogsController@delete', [$log]) }}"
                   class="btn btn-danger pull-right"
                   id="deleteUser">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                </a>
            </div>
        @endforeach
    </div>
@stop