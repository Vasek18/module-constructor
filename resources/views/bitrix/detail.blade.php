@extends('app')

@section('content')

    {{-- todo Проверка на наличие пришедших данных --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Модуль {{$module->PARTNER_CODE}}.{{$module->MODULE_CODE}}</div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop