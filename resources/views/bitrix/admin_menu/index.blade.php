@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_admin_menu.h1') }}
@stop

@section('page')
    <a href="{{action('Modules\Bitrix\BitrixAdminMenuController@create', [$module->id])}}"
       class="btn btn-primary">{{ trans('bitrix_admin_menu.button_add') }}
    </a>
    <hr>
    @if (count($admin_menu_pages))
        <h2>{{ trans('bitrix_admin_menu.pages') }}</h2>
        <div class="list-group">
            @foreach($admin_menu_pages as $admin_menu_page)
                <div class="list-group-item clearfix deletion_wrapper">
                    <a href="{{ action('Modules\Bitrix\BitrixAdminMenuController@show', [$module->id, $admin_menu_page->id]) }}">
                        "{{$admin_menu_page->name}}" ({{ trans('bitrix_admin_menu.'.$admin_menu_page->parent_menu) }})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixAdminMenuController@destroy', [$module->id, $admin_menu_page->id]) }}"
                       class="btn btn-danger pull-right human_ajax_deletion"
                       data-method="get"
                       id="delete_amp_{{$admin_menu_page->id}}">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop