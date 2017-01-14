@extends("admin.template")

@section("page")
    <h1>Оплаты</h1>
    <table class="table table-bordered">
        <tr>
            <th>Сумма</th>
            <th>Дата</th>
            <th>Плательшик</th>
            <th></th>
        </tr>
        @foreach($pays as $pay)
            <tr>
                <td>{{ $pay->amount }}</td>
                <td>{{ $pay->created_at }}</td>
                <td>
                    <a href="{{ action('Admin\AdminUsersController@show', ['user' => $pay->user]) }}">
                        ({{ $pay->user->id }}) {{ $pay->user->last_name }} {{ $pay->user->first_name }}</a>
                </td>
                <td>
                    <a href="{{ action('Admin\AdminPaymentsController@delete', [$pay]) }}"
                       id="delete{{ $pay->id }}"
                       class="btn btn-danger btn-sm deletion-with-confirm">
                          <span class="glyphicon glyphicon-trash"
                                aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@stop