<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bitrix_menu" aria-expanded="false">
                <span class="sr-only">{{ trans('bitrix_top_menu.menu') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bitrix_menu">
            <ul class="nav navbar-nav">
                <li class="{!! classActiveSegment(3, null) !!}">
                    <a href="{{ route('bitrix_module_detail', $module->id) }}">{{ trans('bitrix_top_menu.detail') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'components') !!}">
                    <a href="{{ route('bitrix_module_components', $module->id) }}">{{ trans('bitrix_top_menu.components') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'data_storage') !!}">
                    <a href="{{ route('bitrix_module_data_storage', $module->id) }}">{{ trans('bitrix_top_menu.data_storage') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'admin_options') !!}">
                    <a href="{{ route('bitrix_module_admin_options', $module->id) }}">{{ trans('bitrix_top_menu.admin_options') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'events_handlers') !!}">
                    <a href="{{ route('bitrix_module_events_handlers', $module->id) }}">{{ trans('bitrix_top_menu.events_handlers') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'admin_menu') !!}">
                    <a href="{{ route('bitrix_module_admin_menu', $module->id) }}">{{ trans('bitrix_top_menu.admin_menu') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'arbitrary_files') !!}">
                    <a href="{{ route('bitrix_module_arbitrary_files', $module->id) }}">{{ trans('bitrix_top_menu.arbitrary_files') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'mail_events') !!}">
                    <a href="{{ route('bitrix_module_mail_events', $module->id) }}">{{ trans('bitrix_top_menu.mail_events') }}</a>
                </li>
                <li class="{!! classActiveSegment(3, 'lang') !!}">
                    <a href="{{ route('bitrix_module_lang', $module->id) }}">{{ trans('bitrix_top_menu.lang') }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>