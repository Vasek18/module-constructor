@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_data_storage.h1') }}
@stop

@section('page')

    <h2>{{ trans('bitrix_data_storage.iblocks') }}</h2>
    <a href="{{action('Modules\Bitrix\BitrixDataStorageController@add_ib', [$module->id])}}"
       class="btn btn-primary">{{ trans('bitrix_data_storage.add_iblock_button') }}</a>
    <a href="{{action('Modules\Bitrix\BitrixDataStorageController@xml_ib_import', [$module->id])}}"
       class="btn btn-primary"
       data-toggle="modal"
       data-target="#import_xml">{{ trans('bitrix_data_storage.xml_ib_import_button') }}</a>
    <br>
    <br>
    @if (count($infoblocks))
        <div class="list-group">
            @foreach($infoblocks as $infoblock)
                <div class="list-group-item clearfix infoblock deletion_wrapper">
                    <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $infoblock->id]) }}">
                        {{ trans('bitrix_data_storage.iblock') }} "{{$infoblock->name}}" ({{$infoblock->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@delete_ib', [$module->id, $infoblock->id]) }}"
                       class="btn btn-danger pull-right deletion-with-confirm"
                       data-method="get"
                       id="delete_iblock_{{$infoblock->id}}">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    @include('bitrix.data_storage.xml_ib_import_modal', [ 'module' => $module])
@stop