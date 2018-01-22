<h3>{{trans('personal_index.bitrix')}}
    <a href="{{ action('Modules\Bitrix\BitrixController@create') }}"
       class="btn btn-success pull-right">        {{trans('personal_index.create_bitrix_module')}}</a>
</h3>
@if ($bitrix_modules)
    @foreach($bitrix_modules as $module)
        <div class="panel panel-default">
            <div class="panel-heading">
                @if ($module->is_site)
                    Типовой сайт
                @else
                    {{ trans('app.bitrix_module') }}
                @endif
                "{{$module->name}}"
                ({{$module->PARTNER_CODE.'.'.$module->code}}) | {{ trans('bitrix.field_version') }} {{$module->version}}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="sections-links col-md-8">
                        <dl>
                            <dt>{{ trans('bitrix.field_description') }}</dt>
                            @if($module->description)
                                <dd>{{$module->description}}</dd>
                            @else
                                <dd>
                                    <span class="not-exist">{{ trans('app.not-exist') }}</span>
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-2">
                        <form method="post"
                              action="{{ action('Modules\Bitrix\BitrixController@changeSort', [$module]) }}"
                        >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="sort">Сортировка</label>
                                <input type="text"
                                       id="sort{{ $module->id }}"
                                       name="sort"
                                       class="form-control"
                                       placeholder="Сортировка"
                                       value="{{ $module->sort }}"
                                >
                            </div>
                            <div class="form-group">
                                <button id="setSort{{ $module->id }}"
                                        name="setSort{{ $module->id }}"
                                        class="btn btn-primary btn-sm">Задать
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="actions col-md-2">
                        @if ($module->ifUserHasPermission($user, 'D') || $module->ifUserIsOwner($user))
                            @if ($user->canDownloadModule())
                                @include('bitrix.download_modal', [ 'module' => $module])
                                <a data-toggle="modal"
                                   data-target="#modal_download_{{$module->id}}"
                                   href="#"
                                   class="btn btn-sm btn-block btn-success">
                                <span class="glyphicon glyphicon-download"
                                      aria-hidden="true"></span>
                                    {{ trans('app.download') }}
                                </a>
                            @endif
                        @endif
                        @if ($module->ifUserHasPermission($user, 'D') || $module->ifUserIsOwner($user))
                            <a href="{{ action('Modules\Bitrix\BitrixController@show', $module->id) }}"
                               class="btn btn-sm btn-block btn-primary">
                            <span class="glyphicon glyphicon-wrench"
                                  aria-hidden="true"></span>
                                Разработка
                            </a>
                        @endif
                        @if ($module->ifUserHasPermission($user, 'M') || $module->ifUserIsOwner($user))
                            <a href="{{ action('Modules\Management\ModulesManagementController@index', $module->id) }}"
                               class="btn btn-sm btn-block btn-info">
                            <span class="glyphicon glyphicon-ruble"
                                  aria-hidden="true"></span>
                                Менеджмент
                            </a>
                        @endif
                        @if ($module->ifUserIsOwner($user))
                            <a class="btn btn-sm btn-danger btn-block"
                               data-toggle="modal"
                               data-target="#modal_delete_{{$module->id}}"
                               href="#">
                            <span class="glyphicon glyphicon-trash"
                                  aria-hidden="true"></span>
                                {{ trans('app.delete') }}
                            </a>
                            @include('bitrix.delete_modal', [ 'module' => $module])
                        @endif
                    </div>
                </div>
                @if ($module->ifUserHasPermission($user, 'D') || $module->ifUserIsOwner($user))
                    <hr>
                    <p>
                        <a class="btn btn-info"
                           role="button"
                           data-toggle="collapse"
                           href="#module_dop_indo_{{$module->id}}"
                           aria-expanded="false"
                           aria-controls="module_dop_indo_{{$module->id}}">
                            {{ trans('bitrix.dop_info_title') }}
                        </a>
                    </p>
                    <div class="collapse"
                         id="module_dop_indo_{{$module->id}}">
                        <div class="row">
                            <div class="sections-links col-md-10">
                                <h3>{{ trans('bitrix.components_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->components))
                                    <ul>
                                        @foreach($module->components as $component)
                                            <li>
                                                <a href="{{action('Modules\Bitrix\BitrixComponentsController@show', [$module->id, $component->id])}}">{{$component->name}}
                                                    ({{$component->code}})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_components_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_components', $module->id) }}">{{ trans('bitrix.go_to_components_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.events_handlers_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->handlers))
                                    <ul>
                                        @foreach($module->handlers as $handlers)
                                            <li>
                                                {{$handlers->class}}::{{$handlers->method}}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_events_handlers_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_events_handlers', $module->id) }}">{{ trans('bitrix.go_to_events_handlers_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.admin_options_list_title_in_bitrix_block') }}</h3>
                                <p>{{count($module->options)}} {{ trans('bitrix.settings_in_bitrix_block') }}</p>
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_admin_options', $module->id) }}">{{ trans('bitrix.go_to_admin_options_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.infoblocks_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->infoblocks))
                                    <ul>
                                        @foreach($module->infoblocks as $infoblock)
                                            <li>
                                                <a href="{{ action('Modules\Bitrix\Infoblock\BitrixInfoblockController@show', [$module->id, $infoblock->id]) }}">{{$infoblock->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_infoblocks_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class=" btn btn-primary
                                            "
                                       href="{{ route('bitrix_module_data_storage', $module->id) }}">{{ trans('bitrix.go_to_infoblocks_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.mail_events_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->mailEvents))
                                    <ul>
                                        @foreach($module->mailEvents as $mail_event)
                                            <li>
                                                <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]) }}">{{$mail_event->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_mail_events_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_mail_events', $module->id) }}">{{ trans('bitrix.go_to_mail_events_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.arbitrary_files_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->arbitraryFiles))
                                    <ul>
                                        @foreach($module->arbitraryFiles as $af)
                                            <li>
                                                <a href="{{ route('bitrix_module_arbitrary_files', $module->id) }}">{{$af->path}}{{$af->filename}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_arbitrary_files_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_arbitrary_files', $module->id) }}">{{ trans('bitrix.go_to_arbitrary_files_in_bitrix_block') }}
                                    </a>
                                </p>
                                <hr>
                                <h3>{{ trans('bitrix.admin_menu_pages_list_title_in_bitrix_block') }}</h3>
                                @if (count($module->adminMenuPages))
                                    <ul>
                                        @foreach($module->adminMenuPages as $amp)
                                            <li>
                                                <a href="{{ action('Modules\Bitrix\BitrixAdminMenuController@show', [$module->id, $amp->id]) }}">{{$amp->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('bitrix.no_admin_menu_pages_in_bitrix_block') }}</p>
                                @endif
                                <p>
                                    <a class="btn btn-primary"
                                       href="{{ route('bitrix_module_admin_menu', $module->id) }}">{{ trans('bitrix.go_to_admin_menu_pages_in_bitrix_block') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="panel-footer">{{ trans('bitrix.updated_at') }}: {{$module->updated_at}}</div>
        </div>
    @endforeach

@else
    <p class="lead">Нет ни одного модуля Битрикс. Создайте его сейчас</p>
@endif