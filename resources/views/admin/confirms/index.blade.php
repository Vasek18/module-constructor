@extends("admin.template")

@section("page")
    <h1>На утверждение</h1>
    <h2>Модули</h2>

    <div class="text-right">
        <a href="{{ action('Admin\AdminConfirmsController@clearModulesFormDuplicates') }}"
           class="btn btn-danger">Удалить дубляжи
        </a>
    </div>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>Название</th>
            <th>Код</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($unapproved_modules as $module)
            <tr>
                <td>{{ $module->name }}</td>
                <td>{{ $module->code }}</td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@approveModule', [$module]) }}"
                       class="btn btn-success"
                       id="approve_module{{ $module->id }}">Всё норм
                    </a>
                </td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@deleteModule', [$module]) }}"
                       class="btn btn-danger"
                       id="delete_module{{ $module->id }}">Удалить
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    <h2>События</h2>

    <div class="text-right">
        <a href="{{ action('Admin\AdminConfirmsController@clearEventsFormDuplicates') }}"
           class="btn btn-danger">Удалить дубляжи
        </a>
    </div>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>Модуль</th>
            <th>Код</th>
            <th>Описание</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($unapproved_events as $event)
            <tr>
                <td>{{ $event->module->code }}</td>
                <td>{{ $event->code }}</td>
                <td>{{ $event->description }}</td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@approveEvent', [$event]) }}"
                       class="btn btn-success"
                       id="approve_event{{ $event->id }}">Всё норм
                    </a>
                </td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@deleteEvent', [$event]) }}"
                       class="btn btn-danger"
                       id="delete_event{{ $event->id }}">Удалить
                    </a>
                </td>
            </tr>
        @endforeach
        {{--сразу вместе выводим--}}
        @foreach($marked_events as $event)
            <tr>
                <td>{{ $event->module->code }}</td>
                <td>{{ $event->code }}</td>
                <td>{{ $event->description }}</td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@approveEvent', [$event]) }}"
                       class="btn btn-success"
                       id="approve_event{{ $event->id }}">Всё норм
                    </a>
                </td>
                <td>
                    <a href="{{ action('Admin\AdminConfirmsController@deleteEvent', [$event]) }}"
                       class="btn btn-danger"
                       id="delete_event{{ $event->id }}">Удалить
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@stop