@extends("app")

@section("content")
    <div class="container">
        <h1>Личный кабинет</h1>
        <a href="{{ action('Modules\BitrixController@index') }}" class="btn btn-primary btn-lg">Создать модуль на Битриксе</a>
        <h2>Список модулей</h2>
        @if ( !$bitrix_modules->isEmpty())
            <h3>Битрикс</h3>
            @foreach($bitrix_modules as $module)
                <div class="panel panel-default">
                    <div class="panel-heading">Модуль "{{$module->MODULE_NAME}}" ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})</div>
                    <div class="panel-body">
                        <p> {{$module->MODULE_DESCRIPTION}} </p>
                        <div class="actions pull-right">
                            <a href="{{ action('Modules\BitrixController@detail', $module->id) }}"
                               class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a href="{{ action('Modules\BitrixController@delete', $module->id) }}"
                               class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    <div class="panel-footer">Изменён: {{$module->updated_at}}</div>
                </div>
            @endforeach

        @else
            <p>Пусто</p>
        @endif
    </div>
@stop