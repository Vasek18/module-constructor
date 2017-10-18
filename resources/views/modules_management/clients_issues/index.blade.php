@extends('modules_management.internal_template')

@section('h1')
   Проблемы клиентов
@stop

@section("page")
    <div class="row">
        <div class="col-md-6">
            @include('modules_management.clients_issues.list')
        </div>
        <div class="col-md-6">
            @include('modules_management.clients_issues.create')
        </div>
    </div>
@stop