<div class="row">
    <div class="col-md-9">
        <h2 class="no-margin">Список модулей</h2>
    </div>
    <div class="col-md-3">
        <a href="{{ action('Modules\Bitrix\BitrixController@create') }}" class="btn btn-success pull-right">Создать модуль на
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
                        <dl>
                            <dt>Описание</dt>
                            <dd>{{$module->MODULE_DESCRIPTION}}</dd>
                        </dl>
                    </div>
                    <div class="actions col-md-2">
                        <a href="{{ action('Modules\Bitrix\BitrixController@show', $module->id) }}"
                           class="btn btn-sm btn-block btn-primary">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Редактировать
                        </a>
                        <a class="btn btn-sm btn-danger btn-block" data-toggle="modal"
                           data-target="#modal_delete_{{$module->id}}" href="#">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            Удалить
                        </a>
                        <div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_{{$module->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Удаление модуля</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger" role="alert">Вы уверены?</div>
                                        <form method="post"
                                              action="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}"
                                              class="readonly">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
