<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#bitrix_menu"
                    aria-expanded="false">
                <span class="sr-only">{{ trans('bitrix_top_menu.menu') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand visible-xs">{{ trans('bitrix_top_menu.menu_brand') }}</span>
        </div>
        <div class="collapse navbar-collapse"
             id="bitrix_menu">
            <ul class="nav navbar-nav">
                <li class="{!! classActiveSegment(3, null) !!}">
                    <a href="{{ action('Modules\Management\ModulesManagementController@index', $module->id) }}">Основное</a>
                </li>
                <li class="{!! classActiveSegment(3, 'clients-issues') !!}">
                    <a href="{{ action('Modules\Management\ModulesClientsIssueController@index', $module->id) }}">Проблемы клиентов</a>
                </li>
                <li class="{!! classActiveSegment(3, 'competitors') !!}">
                    <a href="{{ action('Modules\Management\ModulesCompetitorsController@index', $module->id) }}">Проблемы клиентов</a>
                </li>
            </ul>
        </div>
    </div>
</nav>