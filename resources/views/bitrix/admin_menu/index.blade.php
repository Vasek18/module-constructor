@extends('bitrix.internal_template')

@section('h1')
    Страницы административного меню
@stop

@section('page')
    <a href="{{action('Modules\Bitrix\BitrixAdminMenuController@create', [$module->id])}}"
       class="btn btn-primary">Добавить страницу
    </a>
    <hr>
    @if (count($admin_menu_pages))
        <h2>Страницы</h2>
        <div class="list-group">
            @foreach($admin_menu_pages as $admin_menu_page)
                <div class="list-group-item clearfix component">
                    <a href="{{ action('Modules\Bitrix\BitrixAdminMenuController@show', [$module->id, $admin_menu_page->id]) }}">
                        "{{$admin_menu_page->name}}" ({{$admin_menu_page->parent_menu}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixAdminMenuController@destroy', [$module->id, $admin_menu_page->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash"
                              aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop