@extends("admin.template")

@section("page")
    <h1>{{ $module->name }} ({{ $module->code }})</h1>
    <p>Создан: {{ $module->created_at }}</p>
    <h2>{{ trans('bitrix.consist_of') }}</h2>
    <dl class="dl-horizontal">
        <dt>{{ trans('bitrix.components_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_components', $module->id) }}">{{$module->components()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.events_handlers_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_events_handlers', $module->id) }}">{{$module->handlers()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.infoblocks_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_data_storage', $module->id) }}">{{$module->infoblocks()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.admin_options_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_admin_options', $module->id) }}">{{$module->options()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.mail_events_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_mail_events', $module->id) }}">{{$module->mailEvents()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.arbitrary_files_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_arbitrary_files', $module->id) }}">{{$module->arbitraryFiles()->count()}}</a>
        </dd>
        <dt>{{ trans('bitrix.admin_menu_pages_list_title_on_detail') }}:</dt>
        <dd>
            <a href="{{ route('bitrix_module_admin_menu', $module->id) }}">{{$module->adminMenuPages()->count()}}</a>
        </dd>
    </dl>
@stop