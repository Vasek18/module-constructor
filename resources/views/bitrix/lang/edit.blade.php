@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_lang.h1') }}
@stop

@section('page')

    <h2>{{ trans('bitrix_lang.edit_file') }} {{ $file }}</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="file-content">
                {!! $content !!}
            </div>
        </div>
        <div class="col-md-6">
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
            <div class="tab-content">
                @foreach($langs as $langID => $langArr)
                    <div role="tabpanel"
                         class="tab-pane {{ $langID == $module->default_lang ? 'active' : '' }}"
                         id="{{ $langID }}">
                        <table class="table table-bordered">
                            @foreach($langArr as $key => $phrase)
                                <tr>
                                    <td>
                                        <input type="text"
                                               name="lang"
                                               class="form-control"
                                               value="{{ $key }}">
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="lang"
                                               class="form-control"
                                               value="{{ $phrase }}">
                                    </td>
                                </tr>
                            @endforeach
                            @if ($langID == $module->default_lang)
                                @foreach($phrases as $c => $phrase)
                                    <tr>
                                        <td>
                                            <input type="text"
                                                   name="lang"
                                                   class="form-control">
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="lang"
                                                   class="form-control"
                                                   value="{{ $phrase["phrase"] }}">
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop