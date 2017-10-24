@extends('modules_management.internal_template')

@section('h1')
    Конкуренты
@stop

@section("page")
    @include('modules_management.competitors.list')
    <a href="{{ action('Modules\Management\ModulesCompetitorsController@create', $module->id) }}"
       class="btn btn-primary">Записать конкурента</a>
    <hr>
    <h2>Обновления конкурентов</h2>

    {{--Ссылки для парсинга обновлений--}}
    @foreach($competitors as $c => $competitor)
        <input type="hidden" value="{{ action(
                      'Modules\Management\ModulesCompetitorsController@getUpdatesFromParsing',
                       [
                       'module'=>$module->id,
                       'competitor'=>$competitor->id,
                       ]
                       ) }}" name="parse_updates_url[]">
    @endforeach
    <a href="#"
       class="btn btn-success js-check-competitors-updates">Проверить</a>
    <div class="clear"></div>
    <br>
    @include('modules_management.competitors.updates_list')
@stop

@push('scripts')
    <script src="/js/modules_competitors.js"></script>
@endpush