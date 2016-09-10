@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_lang.h1') }}
@stop

@section('page')

    <h2>{{ trans('bitrix_lang.edit_file') }} {{ $file }}</h2>
    <div>
        <div>
            <div class="file-content">
                {!! $content !!}
            </div>
        </div>
        <div>
            <ul class="nav nav-tabs"
                role="tablist">
                @foreach($langs as $langID => $langArr)
                    <li role="presentation"
                        class="{{ $langID == $module->default_lang ? 'active' : '' }}">
                        <a href="#{{ $langID }}"
                           aria-controls="{{ $langID }}"
                           role="tab"
                           data-toggle="tab">{{ $langID }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <form class="tab-content">
                @foreach($langs as $langID => $langArr)
                    <div role="tabpanel"
                         class="tab-pane {{ $langID == $module->default_lang ? 'active' : '' }}"
                         id="{{ $langID }}">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ trans('bitrix_lang.th_key') }}</th>
                                <th>{{ trans('bitrix_lang.th_phrase') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($langArr as $key => $phrase)
                                <tr>
                                    <td>
                                        <p class="form-control-static">
                                            {{ $key }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="form-control-static">
                                            {{ $phrase }}
                                        </p>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            @if ($langID == $module->default_lang)
                                @foreach($phrases as $c => $phrase)
                                    <tr>
                                        <td>
                                            <input type="text"
                                                   name="lang"
                                                   class="form-control"
                                                   value="{{ translit($phrase["phrase"]) }}">
                                        </td>
                                        <td>
                                            <p class="form-control-static">{{ $phrase["phrase"] }}</p>
                                        </td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-primary">{{ trans('bitrix_lang.btn_translate') }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-info">{{ trans('bitrix_lang.btn_translit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
@stop