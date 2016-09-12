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
            <form class="tab-content"
                  method="post"
                  action="{{ action('Modules\Bitrix\BitrixLangController@update', [$module->id]) }}">
                {{ csrf_field() }}
                <input type="hidden"
                       name="file"
                       value="{{ $file }}">
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
                            <?php $i = 0; ?>
                            @foreach($allKeys as $key)
                                <tr class="{{ $key["unused"] ? 'bg-danger' : '' }}">
                                    <td>
                                        <p class="form-control-static">
                                            {{ $key["key"] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="form-control-static">
                                            {{ isset($langArr[$key["key"]]) ? $langArr[$key["key"]] : '' }}
                                        </p>
                                    </td>
                                    <td></td>
                                    <td>
                                        @if ($key["unused"])
                                            <input type="hidden"
                                                   name="code_{{ $i }}"
                                                   value="{{ $key["key"] }}">
                                            <input type="hidden"
                                                   name="phrase_{{ $i }}"
                                                   value="{{ isset($langArr[$key["key"]]) ? $langArr[$key["key"]] : '' }}">
                                            <input type="hidden"
                                                   name="lang_{{ $i }}"
                                                   value="{{ $langID }}">
                                            <button name="delete"
                                                    id="delete_{{ $i }}"
                                                    value="delete_{{ $i }}"
                                                    class="btn btn-danger">{{ trans('app.delete') }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            @if ($langID == $module->default_lang)
                                @foreach($phrases as $c => $phrase)
                                    <tr>
                                        <td>
                                            <input type="text"
                                                   name="code_{{ $c + count($langArr) }}"
                                                   class="form-control"
                                                   value="{{ translit($phrase["phrase"]) }}">
                                        </td>
                                        <td>
                                            <input type="hidden"
                                                   name="phrase_{{ $c + count($langArr) }}"
                                                   value="{{ $phrase["phrase"] }}">
                                            <input type="hidden"
                                                   name="start_pos_{{ $c + count($langArr) }}"
                                                   value="{{ $phrase["start_pos"] }}">
                                            <input type="hidden"
                                                   name="is_comment_{{ $c + count($langArr) }}"
                                                   value="{{ $phrase["is_comment"]?'1':'0' }}">
                                            <input type="hidden"
                                                   name="code_type_{{ $c + count($langArr) }}"
                                                   value="{{ $phrase["code_type"] }}">
                                            <input type="hidden"
                                                   name="lang_{{ $c + count($langArr) }}"
                                                   value="{{ $langID }}">
                                            <p class="form-control-static">{{ $phrase["phrase"] }}</p>
                                        </td>
                                        <td>
                                            <button name="save"
                                                    id="save_{{ $c + count($langArr) }}"
                                                    value="save_{{ $c + count($langArr) }}"
                                                    class="btn btn-primary">{{ trans('bitrix_lang.btn_translate') }}
                                            </button>
                                        </td>
                                        <td>
                                            <button name="translit"
                                                    id="translit_{{ $c + count($langArr) }}"
                                                    value="translit_{{ $c + count($langArr) }}"
                                                    class="btn btn-info">{{ trans('bitrix_lang.btn_translit') }}
                                            </button>
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