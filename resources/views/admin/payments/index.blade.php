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
                    <a href="{{ action('Admin\AdminUsersController@show', ['user' => $pay->user]) }}">({{ $pay->user->id }}) {{ $pay->user->last_name }} {{ $pay->user->first_name }}</a>
                </td>
                <td></td>
            </tr>
        @endforeach
    </table>
@stop