<div class="row">
    <div class="col-md-8">
        <h2>Список модулей</h2>
    </div>
    <div class="col-md-4">
        <a href="{{ action('Modules\Bitrix\BitrixController@index') }}" class="btn btn-primary btn-lg">Создать модуль на
            Битриксе</a>
    </div>
</div>

@if ( !$bitrix_modules->isEmpty())
    <h3>Битрикс</h3>
    @foreach($bitrix_modules as $module)
        <div class="panel panel-default">
            <div class="panel-heading">Модуль "{{$module->MODULE_NAME}}" ({{$module->PARTNER_CODE}}
                .{{$module->MODULE_CODE}}) | Версия {{$module->VERSION}}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="sections-links col-md-10">
                        <p> {{$module->MODULE_DESCRIPTION}} </p>
                    </div>
                    <div class="actions col-md-2">
                        <a href="{{ action('Modules\Bitrix\BitrixController@detail', $module->id) }}"
                           class="btn btn-sm btn-block btn-primary">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Редактировать
                        </a>
                        <a href="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}"
                           class="btn btn-sm btn-block btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            Удалить
                        </a>
                    </div>
                </div>
                <hr>
                <p>
                    <a class="btn btn-primary" role="button" data-toggle="collapse"
                       href="#module_dop_indo_{{$module->id}}"
                       aria-expanded="false" aria-controls="module_dop_indo_{{$module->id}}">
                        Раскрыть дополнительную информацию
                    </a>
                </p>
                <div class="collapse" id="module_dop_indo_{{$module->id}}">
                    <div class="row">
                        <div class="sections-links col-md-10">
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_detail', $module->id) }}">Перейти
                                    в раздел "Основное"</a>
                            </p>
                            <hr>
                            <h3>Компоненты</h3>
                            <ul>
                                @foreach($module->components as $component)
                                    <li>
                                        <a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">{{$component->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_components', $module->id) }}">Перейти в раздел
                                    "Компоненты"</a>
                            </p>
                            <hr>
                            <h3>Обработчики событий</h3>
                            <ul>
                                @foreach($module->handlers as $handlers)
                                    <li>
                                        {{$handlers->class}}::{{$handlers->method}}
                                    </li>
                                @endforeach
                            </ul>
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_events_handlers', $module->id) }}">Перейти
                                    в раздел "Обработчики событий"</a>
                            </p>
                            <hr>
                            <h3>Настройки модуля</h3>
                            <p>{{count($module->options)}} настроек</p>
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_admin_options', $module->id) }}">Перейти
                                    в раздел "Страница настроек"</a>
                            </p>
                            <hr>
                            @if (count($module->infoblocks))
                                <h3>Инфоблоки</h3>
                                <ul>
                                    @foreach($module->infoblocks as $infoblock)
                                        <li>
                                            {{$infoblock->name}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_data_storage', $module->id) }}">Перейти
                                    в раздел "Хранение данных"</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">Изменён: {{$module->updated_at}}</div>
        </div>
    @endforeach

@else
    <p>Пусто</p>
@endif
