@extends('bitrix.internal_template')

@section('page')

    @include('bitrix.components.progress_way_menu')

    @if (isset($template))
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="{!! classActiveSegment(7, null) !!}">
                <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@show', [$module->id, $component->id, $template->id]) }}">{{ trans('bitrix_components.template_menu_item_detail') }}</a>
            </li>
            <li role="presentation"
            class="{!! classActiveSegment(7, 'params') !!}">
                <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@show_params', [$module->id, $component->id, $template->id]) }}">{{ trans('bitrix_components.template_menu_item_params') }}</a>
            </li>
            <li role="presentation"
            class="{!! classActiveSegment(7, 'files') !!}">
                <a href="{{ action('Modules\Bitrix\BitrixComponentsTemplatesController@show_files', [$module->id, $component->id, $template->id]) }}">{{ trans('bitrix_components.template_menu_item_arbitrary_files') }}</a>
            </li>
        </ul>
    @endif
    <br>
    @yield('templates_page')

@stop