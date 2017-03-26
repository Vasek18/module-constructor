@extends("admin.template")

@section("page")
    <h1>Репорты пользователей</h1>

    @foreach($reports as $report)
        <div class="panel panel-{{ $report->getBootstrapContextClass() }}">
            <div class="panel-heading clearfix">{{ $report->name }}
                <div class="pull-right">
                    <a href="{{ action('Admin\AdminUserReportsController@destroy', [$report]) }}"
                       id="delete{{ $report->id }}"
                       class="btn btn-danger btn-sm deletion-with-confirm">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <p>{{ $report->description }}</p>
                <dl>
                    <dt>Страница</dt>
                    <dd>{{ $report->page_link }}</dd>
                    <dt>Пользователь</dt>
                    <dd>
                        @if ($report->user_id)
                            <a href="{{ action('Admin\AdminUsersController@show', ['user' => $report->user_id]) }}">{{ $report->user->name }}</a>
                        @endif
                        {{ $report->user_email }}</dd>
                </dl>
            </div>
        </div>
    @endforeach
@stop