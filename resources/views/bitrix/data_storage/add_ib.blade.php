@extends('bitrix.internal_template')

@section('h1')
    @if (isset($iblock))
        {{ trans('bitrix_iblocks_form.edit_h1') }}
    @else
        {{ trans('bitrix_iblocks_form.add_h1') }}
    @endif
@stop

@section('page')
    @push('scripts')
    <script src="/js/bitrix_iblock.js"></script>
    @endpush

    @push('styles')
    <link href='/css/iblock_form.css'
          rel='stylesheet'/>
    @endpush

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($iblock))
        <form method="post"
              action="{{ action('Modules\Bitrix\BitrixDataStorageController@save_ib', [$module->id, $iblock->id]) }}">
            @else
                <form method="post"
                      action="{{ action('Modules\Bitrix\BitrixDataStorageController@store_ib', $module->id) }}">
                    @endif
                    {{ csrf_field() }}
                    <ul class="nav nav-tabs iblock_tabs_headings"
                        role="tablist">
                        <li role="presentation"
                            class="active">
                            <a href="#infoblok"
                               aria-controls="infoblok"
                               role="tab"
                               data-toggle="tab"
                               data-hash="">{{ trans('bitrix_iblocks_form.tab_iblock_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#seo"
                               aria-controls="seo"
                               role="tab"
                               data-toggle="tab"
                               data-hash="seo">{{ trans('bitrix_iblocks_form.tab_seo_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#fields"
                               aria-controls="fields"
                               role="tab"
                               data-toggle="tab"
                               data-hash="fields">{{ trans('bitrix_iblocks_form.tab_fields_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#properties"
                               aria-controls="properties"
                               role="tab"
                               data-toggle="tab"
                               data-hash="properties">{{ trans('bitrix_iblocks_form.tab_properties_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#sections_fields"
                               aria-controls="sections_fields"
                               role="tab"
                               data-toggle="tab"
                               data-hash="sections_fields">{{ trans('bitrix_iblocks_form.tab_section_fields_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#shop_catalog"
                               aria-controls="shop_catalog"
                               role="tab"
                               data-toggle="tab"
                               data-hash="shop_catalog">{{ trans('bitrix_iblocks_form.tab_shop_catalog_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#permissions"
                               aria-controls="permissions"
                               role="tab"
                               data-toggle="tab"
                               data-hash="permissions">{{ trans('bitrix_iblocks_form.tab_permissions_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#captions"
                               aria-controls="captions"
                               role="tab"
                               data-toggle="tab"
                               data-hash="captions">{{ trans('bitrix_iblocks_form.tab_captions_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#event_log"
                               aria-controls="event_log"
                               role="tab"
                               data-toggle="tab"
                               data-hash="event_log">{{ trans('bitrix_iblocks_form.tab_event_log_title') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#test_data"
                               aria-controls="test_data"
                               role="tab"
                               data-toggle="tab"
                               data-hash="test_data">{{ trans('bitrix_iblocks_form.tab_test_data_title') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel"
                             class="tab-pane active"
                             id="infoblok">
                            @include('bitrix.data_storage.iblock_tabs.infoblok')
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="seo">
                            @include('bitrix.data_storage.iblock_tabs.seo')
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="fields">
                            @include('bitrix.data_storage.iblock_tabs.fields')
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="properties">
                            @include('bitrix.data_storage.iblock_tabs.properties')
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="sections_fields">
                            {{--                @include('bitrix.data_storage.iblock_tabs.sections_fields')--}}
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="shop_catalog">
                            {{--                @include('bitrix.data_storage.iblock_tabs.shop_catalog')--}}
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="permissions">
                            @include('bitrix.data_storage.iblock_tabs.permissions')
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="captions">
                            {{--@include('bitrix.data_storage.iblock_tabs.captions')--}}
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="event_log">
                            {{--                @include('bitrix.data_storage.iblock_tabs.event_log')--}}
                        </div>
                        <div role="tabpanel"
                             class="tab-pane"
                             id="test_data">
                            @include('bitrix.data_storage.iblock_tabs.test_data')
                        </div>
                    </div>
                    <button class="btn btn-primary"
                            name="save">{{ trans('bitrix_iblocks_form.button_save') }}</button>
                </form>

@stop