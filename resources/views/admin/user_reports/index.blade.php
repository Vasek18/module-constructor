@extends("admin.template")

@section("page")
    <h1>Репорты пользователей</h1>


    @foreach($reports as $report)
        <div class="panel panel-primary">
            <div class="panel-heading">{{ $report->name }}</div>
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