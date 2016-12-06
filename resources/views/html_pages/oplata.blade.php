@extends('app')

@section('content')
    <div class="container">
        <h1>Оплата</h1>
        <p class="big-text">Тут можно регистрироваться и трогать весь функционал бесплатно.</p>
        <p class="big-text">Но скачивание архива вне демо-периода мы сделали платным. А поскольку в разделе перевода можно увидеть
            содержимое каждого файла, он также доступен только оплаченным пользователям.
        </p>
        <div class="row">
            <div class="col-md-6">
                <table class="oplata-table table table-striped">
                    <tr>
                        <th>Цена за день в рублях</th>
                        <td><kbd class="bg-primary">{{ setting('day_price') }}</kbd></td>
                    </tr>
                    <tr>
                        <th>Длительность демо-периода в днях</th>
                        <td><kbd class="bg-primary">{{ setting('demo_days') }}</kbd></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop