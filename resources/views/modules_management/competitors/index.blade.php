@extends('modules_management.internal_template')

@section('h1')
    Конкуренты
@stop

@section("page")
    @include('modules_management.competitors.list')
    <a href="{{ action('Modules\Management\ModulesCompetitorsController@create', $module->id) }}"
       class="btn btn-primary">Записать конкурента</a>
@stop