@extends('app')

@section('content')
    <datalist id="core_modules_list">
        @foreach($core_modules as $core_module)
            <option>{{$core_module->code}}</option>
        @endforeach
    </datalist>
    <div class="container">
        <h1>{{ trans('project_help.bitrix_events_h1') }}</h1>
        <p>{{ trans('project_help.bitrix_events_p') }}</p>
        <form method="post"
              action="{{ action('ProjectHelpController@bitrixEventsAdd') }}">
            {{ csrf_field() }}
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}
                    <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th>
                        {{ trans('project_help.bitrix_events_module_th') }}
                    </th>
                    <th>
                        {{ trans('project_help.bitrix_events_event_th') }}
                    </th>
                    <th>
                        {{ trans('project_help.bitrix_events_params_th') }}
                    </th>
                    <th>
                        {{ trans('project_help.bitrix_events_description_th') }}
                    </th>
                    <th>
                        {{ trans('project_help.bitrix_events_action_th') }}
                    </th>
                </tr>
                @foreach($existing_events as $existing_event)
                    <tr>
                        <td>
                            {{ $existing_event->module->code }}
                        </td>
                        <td>
                            {{ $existing_event->code }}
                        </td>
                        <td>
                            {{ $existing_event->params }}
                        </td>
                        <td>
                            {{ $existing_event->description }}
                        </td>
                        <td>
                            <a href="{{ action('ProjectHelpController@bitrixEventsMarkAsBad', $existing_event) }}"
                               class="btn btn-warning btn-block"
                               id="mark_as_bad{{ $existing_event->id }}"
                               rel="nofollow">{{ trans('project_help.bitrix_events_mark_bad_action') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <input type="text"
                               name="module"
                               placeholder="{{ trans('project_help.bitrix_events_module_th') }}"
                               class="form-control"
                               list="core_modules_list"
                               required>
                    </td>
                    <td>
                        <input type="text"
                               name="event"
                               placeholder="{{ trans('project_help.bitrix_events_event_th') }}"
                               class="form-control"
                               required>
                    </td>
                    <td>
                        <input type="text"
                               name="params"
                               placeholder="{{ trans('project_help.bitrix_events_params_th') }}"
                               class="form-control">
                    </td>
                    <td>
                         <textarea name="description"
                                   class="form-control"></textarea>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-block"
                                name="offer">{{ trans('project_help.bitrix_events_suggest_action') }}</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@stop