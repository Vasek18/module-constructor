<h3>{{trans('personal_index.bitrix')}}
    <a href="{{ action('Modules\Bitrix\BitrixController@create') }}"
       class="btn btn-success pull-right">        {{trans('personal_index.create_bitrix_module')}}</a>
</h3>
@if ( !$bitrix_modules->isEmpty())
    @foreach($bitrix_modules as $module)
        <div class="panel panel-default">
            <div class="panel-heading">Модуль "{{$module->name}}" ({{$module->PARTNER_CODE}}
                .{{$module->code}}) | Версия {{$module->version}}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="sections-links col-md-10">
                        <dl>
                            <dt>Описание</dt>
                            @if($module->description)
                                <dd>{{$module->description}}</dd>
                            @else
                                <dd><span class="not-exist">Отсутствует</span></dd>
                            @endif
                        </dl>
                    </div>
                    <div class="actions col-md-2">
                        @if ($user->haveEnoughMoneyForDownload())
                            <a data-toggle="modal" data-target="#modal_download_{{$module->id}}" href="#"
                               class="btn btn-sm btn-block btn-success">
                                <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
                                Скачать
                            </a>
                        @endif
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
                        @include('bitrix.download_modal', [ 'module' => $module])
                        @include('bitrix.delete_modal', [ 'module' => $module])
                    </div>
                </div>
                <hr>
                <p>
                    <a class="btn btn-info" role="button" data-toggle="collapse"
                       href="#module_dop_indo_{{$module->id}}"
                       aria-expanded="false" aria-controls="module_dop_indo_{{$module->id}}">
                        Дополнительная информация
                    </a>
                </p>
                <div class="collapse" id="module_dop_indo_{{$module->id}}">
                    <div class="row">
                        <div class="sections-links col-md-10">
                            <h3>Компоненты</h3>
                            @if (count($module->components))
                                <ul>
                                    @foreach($module->components as $component)
                                        <li>
                                            <a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">{{$component->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Нет собственных компонент</p>
                            @endif
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_components', $module->id) }}">Перейти в раздел
                                    "Компоненты"
                                </a>
                            </p>
                            <hr>
                            <h3>Обработчики событий</h3>
                            @if (count($module->handlers))
                                <ul>
                                    @foreach($module->handlers as $handlers)
                                        <li>
                                            {{$handlers->class}}::{{$handlers->method}}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Ни одного</p>
                            @endif
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_events_handlers', $module->id) }}">Перейти
                                    в раздел "Обработчики событий"
                                </a>
                            </p>
                            <hr>
                            <h3>Настройки модуля</h3>
                            <p>{{count($module->options)}} настроек</p>
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_admin_options', $module->id) }}">Перейти
                                    в раздел "Страница настроек"
                                </a>
                            </p>
                            <hr>
                            <h3>Инфоблоки</h3>
                            @if (count($module->infoblocks))
                                <ul>
                                    @foreach($module->infoblocks as $infoblock)
                                        <li>
                                            <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $infoblock->id]) }}">{{$infoblock->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Никакие данные не хранятся</p>
                            @endif
                            <p>
                                <a class=" btn btn-primary
                                            "
                                   href="{{ route('bitrix_module_data_storage', $module->id) }}">Перейти
                                    в раздел "Хранение данных"
                                </a>
                            </p>
                            <hr>
                            <h3>Почтовые события</h3>
                            @if (count($module->mailEvents))
                                <ul>
                                    @foreach($module->mailEvents as $mail_event)
                                        <li>
                                            <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]) }}">{{$mail_event->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Не работает с почтой</p>
                            @endif
                            <p>
                                <a class="btn btn-primary"
                                   href="{{ route('bitrix_module_mail_events', $module->id) }}">Перейти
                                    в раздел "Почтовые события"
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">Изменён: {{$module->updated_at}}</div>
        </div>
    @endforeach

@else
    <p>{{trans('personal_index.empty')}}</p>
@endif
