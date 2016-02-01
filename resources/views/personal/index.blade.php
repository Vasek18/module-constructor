@extends("app")

@section("content")
    <div class="container">
        <h1>Личный кабинет</h1>
        <h2>Список модулей</h2>
        @if ( !$bitrix_modules->isEmpty())
            <h3>Битрикс</h3>
            @foreach($bitrix_modules as $module)
                <div class="panel panel-default">
                    <div class="panel-heading">{{$module->PARTNER_CODE}}.{{$module->MODULE_NAME}}</div>
                    <div class="panel-body">
                        <p> {{$module->MODULE_DESCRIPTION}} </p>
                        <div class="actions pull-right">
                            <a href="#" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    <div class="panel-footer">Изменён: {{$module->updated_at}}</div>
                </div>
            @endforeach

        @endif
    </div>
@stop