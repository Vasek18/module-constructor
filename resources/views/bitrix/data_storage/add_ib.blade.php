@extends('bitrix.internal_template')

@section('h1')
    Добавить инфоблок
@stop

@section('page')

    <form method="post" action="{{ action('Modules\Bitrix\BitrixDataStorageController@store_ib', $module->id) }}">
        {{ csrf_field() }}
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#infoblok" aria-controls="infoblok" role="tab"
                   data-toggle="tab">Инфоблок</a>
            </li>
            <li role="presentation">
                <a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">Seo</a>
            </li>
            <li role="presentation">
                <a href="#fields" aria-controls="fields" role="tab" data-toggle="tab">Поля</a>
            </li>
            <li role="presentation">
                <a href="#properties" aria-controls="properties" role="tab" data-toggle="tab">Свойства</a>
            </li>
            <li role="presentation">
                <a href="#sections_fields" aria-controls="sections_fields" role="tab" data-toggle="tab">Поля
                    разделов</a>
            </li>
            <li role="presentation">
                <a href="#shop_catalog" aria-controls="shop_catalog" role="tab" data-toggle="tab">Торговый каталог</a>
            </li>
            <li role="presentation">
                <a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">Права доступа</a>
            </li>
            <li role="presentation">
                <a href="#captions" aria-controls="captions" role="tab" data-toggle="tab">Подписи</a>
            </li>
            <li role="presentation">
                <a href="#event_log" aria-controls="event_log" role="tab" data-toggle="tab">Журнал событий</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="infoblok">
                @include('bitrix.data_storage.iblock_tabs.infoblok')
            </div>
            <div role="tabpanel" class="tab-pane" id="seo">
{{--                @include('bitrix.data_storage.iblock_tabs.seo')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="fields">
{{--                @include('bitrix.data_storage.iblock_tabs.fields')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="properties">
{{--                @include('bitrix.data_storage.iblock_tabs.properties')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="sections_fields">
{{--                @include('bitrix.data_storage.iblock_tabs.sections_fields')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="shop_catalog">
{{--                @include('bitrix.data_storage.iblock_tabs.shop_catalog')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="permissions">
{{--                @include('bitrix.data_storage.iblock_tabs.permissions')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="captions">
                {{--@include('bitrix.data_storage.iblock_tabs.captions')--}}
            </div>
            <div role="tabpanel" class="tab-pane" id="event_log">
{{--                @include('bitrix.data_storage.iblock_tabs.event_log')--}}
            </div>
        </div>
        <button class="btn btn-primary">Сохранить</button>
    </form>

@stop