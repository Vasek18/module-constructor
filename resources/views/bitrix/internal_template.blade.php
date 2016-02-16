@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('bitrix.menu')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">@yield('h1') | Модуль "{{$module->MODULE_NAME}}"
                            ({{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}})
                        </div>
                        <div class="panel-body">
                            @yield('page')
                        </div>
                    @else
                        <div class="panel-body">
                            Ошибка!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop