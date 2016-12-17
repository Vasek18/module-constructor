@extends("admin.template")

@section("page")
    <div class="row">
        <div class="col-md-8">
            <h1 class="no-margin">{{ $file_name }}</h1>
        </div>
        <div class="col-md-4">
            <a href="{{ action('Admin\AdminLogsController@delete', [$file_name]) }}"
               class="btn btn-danger"
               id="deleteUser">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="content">
        {!! $content !!}
    </div>
@stop