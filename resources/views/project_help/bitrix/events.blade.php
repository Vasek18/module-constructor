@extends('app')

@section('content')
    <div class="container">
        <h1>События Битрикса</h1>
        <p>Тут вы можете добавить события Битрикса, которые не присутствуют в системе.</p>
        <form method="post">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}
                    <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th>
                        Модуль
                    </th>
                    <th>
                        Событие
                    </th>
                    <th>
                        Параметры
                    </th>
                    <th>
                        Описание
                    </th>
                    <th>
                        Действия
                    </th>
                </tr>
                @foreach($existing_events as $existing_event)
                    <tr>
                        <td>
                        </td>
                        <td>
                            {{ $existing_event->code }}
                        </td>
                        <td>
                            {{ $existing_event->params }}
                        </td>
                        <td>
                            {{ $existing_event->description }}
                        </td>
                        <td>
                            <a class="btn btn-warning btn-block">Устарело/неправильно</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <input type="text"
                               name="module"
                               placeholder="Модуль"
                               class="form-control"
                               required>
                    </td>
                    <td>
                        <input type="text"
                               name="event"
                               placeholder="Событие"
                               class="form-control"
                               required>
                    </td>
                    <td>
                        <input type="text"
                               name="params"
                               placeholder="Параметры"
                               class="form-control"
                               required>
                    </td>
                    <td>
                         <textarea name="description"
                                   class="form-control"></textarea>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-block">Предложить</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@stop