@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_data_storage.h1') }}
@stop

@section('page')

    <h2>{{ trans('bitrix_data_storage.iblocks') }}</h2>
    <a href="{{action('Modules\Bitrix\BitrixDataStorageController@add_ib', [$module->id])}}"
       class="btn btn-primary">{{ trans('bitrix_data_storage.add_iblock_button') }}</a>
    <br>
    <br>
    @if (count($infoblocks))
        <div class="list-group deletion_wrapper">
            @foreach($infoblocks as $infoblock)
                <div class="list-group-item clearfix infoblock">
                    <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $infoblock->id]) }}">
                        {{ trans('bitrix_data_storage.iblock') }} "{{$infoblock->name}}" ({{$infoblock->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@delete_ib', [$module->id, $infoblock->id]) }}"
                       class="btn btn-danger pull-right human_ajax_deletion"
                       data-method="get"
                       id="delete_iblock_{{$infoblock->id}}">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop